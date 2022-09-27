<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Publishment;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class PublishmentRepository extends Repository
{
    public function __construct(
        private readonly Publishment $publishment
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->publishment
            ->when($request->get('name'), function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->get('name')}%");
            })
            ->when($request->get('licence'), function ($query) use ($request) {
                $query->where('licence', 'LIKE', "%{$request->get('licence')}%");
            })
            ->when($request->get('corporation'), function ($query) use ($request) {
                $query->where('corporation', 'LIKE', "%{$request->get('corporation')}%");
            })
            ->when($request->get('mobile'), function ($query) use ($request) {
                $query->where('mobile', 'LIKE', "%{$request->get('mobile')}%");
            })
            ->when($request->get('mail'), function ($query) use ($request) {
                $query->where('mail', 'LIKE', "%{$request->get('mail')}%");
            })
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->when($request->get('audit'), function ($query) use ($request) {
                $query->where('audit', $request->get('audit'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->publishment->getKeyName());

        $data = $data->Paginate($request->get('per', $this->publishment->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type    = $items->getType($items->type);
            $items->audit   = $items->getAudit($items->audit);
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.publishment.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.publishment.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'type' => $this->publishment->getType(),
            'audit' => $this->publishment->getAudit(),
            'state' => $this->publishment->getState(),
        ];

        return compact('filter', 'data');
    }

    public function edit(Request $request): array
    {
        $data = $this->publishment->find($request->get($this->publishment->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'type' => $this->publishment->getType(),
            'audit' => $this->publishment->getAudit(),
            'state' => $this->publishment->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $publishment = $this->publishment->find($request->get($this->publishment->getKeyName()));

        if (is_null($publishment)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $publishment->update([
            'type' => $request->get('type'),
            'name' => $request->get('name'),
            'licence' => $request->get('licence'),
            'licence_image' => $request->get('licence_image'),
            'corporation' => $request->get('corporation'),
            'mobile' => $request->get('mobile'),
            'state' => $request->get('state'),
            'audit' => $request->get('audit'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->publishment->destroy($request->get($this->publishment->getKeyName())) === 0);
    }
}
