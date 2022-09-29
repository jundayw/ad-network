<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\System;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class SystemRepository extends Repository
{
    public function __construct(
        private readonly System $system
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->system
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('key'), function ($query) use ($request) {
                $query->where('key', 'LIKE', "%{$request->get('key')}%");
            })
            ->when($request->get('value'), function ($query) use ($request) {
                $query->where('value', 'LIKE', "%{$request->get('value')}%");
            })
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->latest('modifiable')
            ->latest($this->system->getKeyName());

        $data = $data->Paginate($request->get('per', $this->system->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->value      = $items->getValue($items->value);
            $items->type       = $items->getType($items->type);
            $items->modifiable = $items->getModifiable($items->modifiable);
            $items->edit       = route('backend.system.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy    = route('backend.system.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'type' => $this->system->getType(),
            'modifiable' => $this->system->getModifiable(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'type' => $this->system->getType(),
            'modifiable' => $this->system->getModifiable(),
        ];

        return compact('filter');
    }

    public function store(Request $request): System
    {
        $data = [
            'title' => $request->get('title'),
            'key' => $request->get('key'),
            'type' => $request->get('type'),
            'options' => $request->get('options'),
            'modifiable' => $request->get('modifiable'),
            'description' => $request->get('description'),
        ];

        if (!in_array($request->get('type'), ['radio', 'select', 'checkbox'])) {
            $data['value'] = $request->get('options');
        }

        $system = $this->system->create($data);

        if (is_null($system)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $system;
    }

    public function edit(Request $request): array
    {
        $data = $this->system->where([
            'modifiable' => 'NORMAL',
        ])->find($request->get($this->system->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $options = [];

        if (in_array($data->type, ['radio', 'select', 'checkbox'])) {
            $options = json_decode($data->options, true);
        }

        $filter = [
            'options' => $options,
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $system = $this->system->where([
            'modifiable' => 'NORMAL',
        ])->find($request->get($this->system->getKeyName()));

        if (is_null($system)) {
            throw new RenderErrorResponseException('参数有误');
        }

        cache()->forget('system');

        return $system->update([
            'title' => $request->get('title'),
            'value' => $request->get('value'),
            'description' => $request->get('description'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        throw new RenderErrorResponseException('系统配置不允许删除');
        return !($this->system->destroy($request->get($this->system->getKeyName())) === 0);
    }
}
