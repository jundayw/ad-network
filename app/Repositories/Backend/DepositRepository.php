<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Deposit;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositRepository extends Repository
{
    public function __construct(
        private readonly Deposit $deposit
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->deposit
            ->withWhereHas('deposit', function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('deposit_number'), function ($query) use ($request) {
                $query->where('deposit_number', 'LIKE', "%{$request->get('deposit_number')}%");
            })
            ->when($request->get('payment_number'), function ($query) use ($request) {
                $query->where('payment_number', 'LIKE', "%{$request->get('payment_number')}%");
            })
            ->when($request->get('remark'), function ($query) use ($request) {
                $query->where('remark', 'LIKE', "%{$request->get('remark')}%");
            })
            ->when($request->get('depositer'), function ($query) use ($request) {
                $query->where('deposit_type', $request->get('depositer'));
            })
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->when($request->get('payment'), function ($query) use ($request) {
                $query->where('payment', $request->get('payment'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->latest($this->deposit->getKeyName());

        $data = $data->Paginate($request->get('per', $this->deposit->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->depositer = $items->depositer($items->deposit->getTable());
            $items->type      = $items->getType($items->type);
            $items->payment   = $items->getPayment($items->payment);
            $items->state     = $items->getState($items->state);
            $items->edit      = route('backend.deposit.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy   = route('backend.deposit.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'depositer' => $this->deposit->depositer(),
            'type' => $this->deposit->getType(),
            'payment' => $this->deposit->getPayment(),
            'state' => $this->deposit->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'type' => $this->deposit->getType(),
            'state' => $this->deposit->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Deposit
    {
        $deposit_number = generate_unlined(16);
        $payment_number = generate_unlined(18);

        DB::beginTransaction();

        $deposit = $this->deposit->create([
            'deposit_number' => $deposit_number,
            'payment_number' => $payment_number,
            'deposit_id' => $request->get('id'),
            'deposit_type' => $request->get('deposit'),
            'type' => $request->get('type'),
            'payment' => 'OFFLINE',
            'amount' => $request->get('amount'),
            'remark' => $request->get('remark'),
            'state' => 'SUCCESS',
        ]);

        if ($request->get('type') == 'withdraw') {
            $balance = $deposit->deposit->getOriginal('balance') - $deposit->getOriginal('amount');
            $update  = [
                'balance' => $balance,
            ];
        } else {
            $total   = $deposit->deposit->getOriginal('total') + $deposit->getOriginal('amount');
            $balance = $deposit->deposit->getOriginal('balance') + $deposit->getOriginal('amount');
            $update  = [
                'total' => $total,
                'balance' => $balance,
            ];
        }

        if ($balance < 0) {
            DB::rollBack();
            throw new RenderErrorResponseException('金额有误');
        }

        if (!$deposit->deposit->update($update)) {
            DB::rollBack();
            throw new RenderErrorResponseException('更新关联失败');
        }

        if (is_null($deposit)) {
            DB::rollBack();
            throw new RenderErrorResponseException('新增失败');
        }

        DB::commit();

        return $deposit;
    }

    public function edit(Request $request): array
    {
        $data = $this->deposit->with([
            'deposit',
        ])->find($request->get($this->deposit->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->deposit->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        if (in_array($request->get('state'), ['wait', 'init'])) {
            return false;
        }

        $deposit = $this->deposit->with([
            'deposit',
        ])->where('state', 'wait')->find($request->get($this->deposit->getKeyName()));

        if (is_null($deposit)) {
            throw new RenderErrorResponseException('操作失败');
        }

        DB::beginTransaction();

        $result = $deposit->update([
            'state' => $request->get('state'),
        ]);

        if (!$result) {
            DB::rollBack();
            throw new RenderErrorResponseException('更新流水失败');
        }

        if ($deposit->getOriginal('amount') > $deposit->deposit->getOriginal('frozen')) {
            DB::rollBack();
            throw new RenderErrorResponseException('冻结金额异常');
        }

        $update = [];

        if ($request->get('state') == 'success') {
            $update = [
                'frozen' => $deposit->deposit->getOriginal('frozen') - $deposit->getOriginal('amount'),
            ];
        }

        if ($request->get('state') == 'failure') {
            $update = [
                'balance' => $deposit->deposit->getOriginal('balance') + $deposit->getOriginal('amount'),
                'frozen' => $deposit->deposit->getOriginal('frozen') - $deposit->getOriginal('amount'),
            ];
        }

        if (!$deposit->deposit->update($update)) {
            DB::rollBack();
            throw new RenderErrorResponseException('更新主体失败');
        }

        DB::commit();

        return $result;
    }

    public function destroy(Request $request): bool
    {
        return !($this->deposit->destroy($request->get($this->deposit->getKeyName())) === 0);
    }
}
