<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Module;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ModuleRepository extends Repository
{
    public function __construct(private readonly Module $module)
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->module
            ->when($request->get('namespace'), function ($query) use ($request) {
                $query->where('namespace', 'LIKE', "%{$request->get('namespace')}%");
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest('sorting')
            ->latest('id');

        $data = $data->Paginate($request->get('per', $this->module->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.module.edit', ['id' => $items->id]);
            $items->destroy = route('backend.module.destroy', ['id' => $items->id]);
            return $items;
        });

        $filter = [
            'states' => $this->module->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'state' => $this->module->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request)
    {
        $data = $this->module->create([
            'namespace' => $request->get('namespace'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);

        if (is_null($data)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $data;
    }

    public function edit(Request $request): array
    {
        $data = $this->module->find($request->get($this->module->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->module->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $module = $this->module->find($request->get($this->module->getKeyName()));

        if (is_null($module)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $module->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->module->destroy($request->get($this->module->getKeyName())) === 0);
    }
}
