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
            ->latest($this->system->getKeyName());

        $data = $data->Paginate($request->get('per', $this->system->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->value   = $items->getValue($items->value);
            $items->type    = $items->getType($items->type);
            $items->edit    = route('backend.system.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.system.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'type' => $this->system->getType(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'type' => $this->system->getType(),
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
        $data = $this->system->find($request->get($this->system->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'options' => $data->options,
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $system = $this->system->find($request->get($this->system->getKeyName()));

        if (is_null($system)) {
            throw new RenderErrorResponseException('参数有误');
        }

        cache()->forget('system');

        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];

        if (!in_array($system->getAttribute('type'), ['static'])) {
            $data['value'] = $request->get('value');
        }

        return $system->update($data);
    }

    public function destroy(Request $request): bool
    {
        throw new RenderErrorResponseException('系统配置不允许删除');
        return !($this->system->destroy($request->get($this->system->getKeyName())) === 0);
    }
}
