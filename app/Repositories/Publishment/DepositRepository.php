<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Deposit;
use App\Models\Publishment;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class DepositRepository extends Repository
{
    public function __construct(
        private readonly Deposit $deposit,
        private readonly Publishment $publishment,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->deposit
            ->when($request->get('deposit_number'), function ($query) use ($request) {
                $query->where('deposit_number', 'LIKE', "%{$request->get('deposit_number')}%");
            })
            ->when($request->get('payment_number'), function ($query) use ($request) {
                $query->where('payment_number', 'LIKE', "%{$request->get('payment_number')}%");
            })
            ->when($request->get('remark'), function ($query) use ($request) {
                $query->where('remark', 'LIKE', "%{$request->get('remark')}%");
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
            ->where([
                'deposit_id' => $request->user()->getAttribute('publishment_id'),
                'deposit_type' => 'publishment',
            ])
            ->latest($this->deposit->getKeyName());

        $data = $data->Paginate($request->get('per', $this->deposit->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type    = $items->getType($items->type);
            $items->payment = $items->getPayment($items->payment);
            $items->state   = $items->getState($items->state);
            return $items;
        });

        $filter = [
            'type' => $this->deposit->getType(),
            'payment' => $this->deposit->getPayment(),
            'state' => $this->deposit->getState(),
        ];

        return compact('filter', 'data');
    }

    public function recharge(Request $request): array
    {
        $filter = [
            'type' => $this->deposit->getType(),
            'payment' => $this->deposit->getPayment(),
            'state' => $this->deposit->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Deposit
    {
        if (in_array($request->get('payment'), ['alipay', 'wechat'])) {
            throw new RenderErrorResponseException('暂未启用该交易渠道');
        }

        $count = $this->deposit->where([
            'deposit_id' => $request->user()->getAttribute('publishment_id'),
            'deposit_type' => 'publishment',
            'type' => 'RECHARGE',
            'state' => 'WAIT',
        ])->count();

        if ($count > 0) {
            throw new RenderErrorResponseException('您有一笔待处理的充值，请稍后再试');
        }

        $deposit_number = generate_unlined(16);
        $payment_number = generate_unlined(18);

        $deposit = $this->deposit->create([
            'deposit_number' => $deposit_number,
            'payment_number' => $payment_number,
            'deposit_id' => $request->user()->getAttribute('publishment_id'),
            'deposit_type' => 'publishment',
            'type' => 'RECHARGE',
            'payment' => $request->get('payment'),
            'amount' => $request->get('amount'),
            'remark' => $request->get('remark'),
            'state' => 'WAIT',
        ]);

        if (is_null($deposit)) {
            throw new RenderErrorResponseException('新增失败');
        }

        $request->user()->publishment->increment('frozen', $deposit->getRawOriginal('amount'));

        return $deposit;
    }

    public function withdraw(Request $request): array
    {
        $data = $this->publishment->find($request->user()->getAttribute('publishment_id'));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'type' => $this->deposit->getType(),
            'payment' => $this->deposit->getPayment(),
            'state' => $this->deposit->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): Deposit
    {
        $count = $this->deposit->where([
            'deposit_id' => $request->user()->getAttribute('publishment_id'),
            'deposit_type' => 'publishment',
            'type' => 'WITHDRAW',
            'state' => 'WAIT',
        ])->count();

        if ($count > 0) {
            throw new RenderErrorResponseException('您有一笔待处理的提现，请稍后再试');
        }

        $publishment = $this->publishment->find($request->user()->getAttribute('publishment_id'));

        if (is_null($publishment)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        if ($request->get('amount') > $publishment->getAttribute('balance')) {
            throw new RenderErrorResponseException('余额不足');
        }

        $deposit_number = generate_unlined(16);
        $payment_number = generate_unlined(18);

        $deposit = $this->deposit->create([
            'deposit_number' => $deposit_number,
            'payment_number' => $payment_number,
            'deposit_id' => $request->user()->getAttribute('publishment_id'),
            'deposit_type' => 'publishment',
            'type' => 'WITHDRAW',
            'payment' => 'OFFLINE',
            'amount' => $request->get('amount'),
            'remark' => $request->get('remark'),
            'state' => 'WAIT',
        ]);

        if (is_null($deposit)) {
            throw new RenderErrorResponseException('新增失败');
        }

        $request->user()->publishment->decrement('balance', $deposit->getRawOriginal('amount'));
        $request->user()->publishment->increment('frozen', $deposit->getRawOriginal('amount'));

        return $deposit;
    }
}
