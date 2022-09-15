<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Module;
use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class RoleRepository extends Repository
{
    public function __construct(
        private readonly Role $role,
        private readonly Module $module,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->role
            ->with([
                'module',
            ])
            ->when($request->get('module_id'), function ($query) use ($request) {
                $query->where('module_id', $request->get('module_id'));
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('module_id')
            ->oldest('state')
            ->latest('sorting')
            ->oldest($this->role->getKeyName());

        $data = $data->Paginate($request->get('per', $this->role->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.role.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.role.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'states' => $this->role->getState(),
            'modules' => $this->module->select('id', 'title')->get(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'state' => $this->role->getState(),
            'modules' => $this->module->select('id', 'title')->get(),
        ];

        return compact('filter');
    }

    public function store(Request $request)
    {
        $module = $this->module->find($request->get('module_id'));

        if (is_null($module)) {
            throw new RenderErrorResponseException('模块参数有误');
        }

        $data = $this->role->create([
            'module_namespace' => $module->namespace,
            'module_id' => $request->get('module_id'),
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
        $data = $this->role->with([
            'module.policies' => function ($query) {
                $query->with([
                    'policies',
                ])->where('type', 'PAGE')
                    ->oldest('state')
                    ->latest('sorting');
            },
        ])->find($request->get($this->role->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->role->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $data = $this->role->find($request->get($this->role->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $data->rolePolicies()->sync($request->get('policies'));

        return $data->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'policies' => $request->get('policies'),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->role->destroy($request->get($this->role->getKeyName())) === 0);
    }
}
