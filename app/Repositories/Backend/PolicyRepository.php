<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Module;
use App\Models\Policy;
use App\Repositories\Repository;
use App\Services\Backend\PolicyService;
use Illuminate\Http\Request;

class PolicyRepository extends Repository
{
    public function __construct(
        private readonly Policy $policy,
        private readonly Module $module,
        private readonly PolicyService $policyService,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->policy->with([
            'module',
            'policies' => function ($query) {
                $query->with([
                    'policies' => function ($query) {
                        $query->oldest('state')->latest('sorting');
                    },
                ])->oldest('state')->latest('sorting');
            },
        ])->where('pid', 0)
            ->when($request->get('module_id'), function ($query) use ($request) {
                $query->where('module_id', $request->get('module_id'));
            })
            ->oldest('module_id')
            ->oldest('state')
            ->latest('sorting');

        $data = $data->Paginate($request->get('per', $this->policy->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type    = $items->getType($items->type);
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.policy.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.policy.destroy', [$items->getKeyName() => $items->getKey()]);
            $items->policies->transform(function ($policies) {
                $policies->type    = $policies->getType($policies->type);
                $policies->state   = $policies->getState($policies->state);
                $policies->edit    = route('backend.policy.edit', [$policies->getKeyName() => $policies->getKey()]);
                $policies->destroy = route('backend.policy.destroy', [$policies->getKeyName() => $policies->getKey()]);
                $policies->policies->transform(function ($policy) {
                    $policy->type    = $policy->getType($policy->type);
                    $policy->state   = $policy->getState($policy->state);
                    $policy->edit    = route('backend.policy.edit', [$policy->getKeyName() => $policy->getKey()]);
                    $policy->destroy = route('backend.policy.destroy', [$policy->getKeyName() => $policy->getKey()]);
                    return $policy;
                });
                return $policies;
            });
            return $items;
        });

        $filter = [
            'modules' => $this->module->select('id', 'title')->get(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $modules = $this->module->with([
            'policies' => function ($query) {
                $query->with([
                    'policies',
                ])->where('pid', 0)
                    ->where('state', 'NORMAL')
                    ->latest('sorting');
            },
        ])->where('state', 'NORMAL')
            ->latest('sorting')
            ->get();

        $filter = [
            'modules' => $modules,
            'routes' => $this->policyService->getRoutesNames(),
            'states' => $this->policy->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Policy
    {
        $module = $request->get('module');
        $module = explode(',', $module);

        $pid  = count($module) < 2 ? 0 : end($module);
        $type = match (count($module)) {
            1 => 'NAVIGATION',
            2 => 'PAGE',
            default => 'NODE'
        };

        $module = $this->module->where('id', reset($module))->first();

        if (is_null($module)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $data = $this->policy->create([
            'module_namespace' => $module->namespace,
            'module_id' => $module->getKey(),
            'pid' => $pid,
            'title' => $request->get('title'),
            'type' => $type,
            'icon' => $request->get('icon'),
            'url' => $request->get('url'),
            'statement' => $request->get('statement', []),
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
        $data = $this->policy->find($request->get($this->policy->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'routes' => $this->policyService->getRoutesNames(),
            'states' => $this->policy->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $data = $this->policy->find($request->get($this->policy->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'title' => $request->get('title'),
            'icon' => $request->get('icon'),
            'url' => $request->get('url'),
            'statement' => $request->get('statement', []),
            'description' => $request->get('description'),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $policy = $this->policy->where('pid', $request->get($this->policy->getKeyName()))->first();

        if (!is_null($policy)) {
            throw new RenderErrorResponseException('当前策略下含有子策略，请先删除');
        }

        return !($this->policy->destroy($request->get($this->policy->getKeyName())) === 0);
    }
}
