<?php

namespace App\Http\View\Composers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * 根据当前登录用户，获取[角色]关联[策略]
 * 并根据[策略]所属[菜单]重组数据结构
 */
class NavigationComposer
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function compose(View $view): void
    {
        $navigations = [];

        if (!is_null($this->request->user())) {
            $navigations = $this->resolutionNavigations($this->getNavigations());
        }

        $view->with(compact('navigations'));
    }

    private function getNavigations()
    {
        $key = sprintf('%s::%s', static::class, $this->request->user()->getAttribute('role_id'));
        return Cache::rememberForever($key, function () {
            return $this->getRolePoliciesNavigations();
        });
    }

    private function getRolePoliciesNavigations()
    {
        return $this->request->user()->role()->with([
            'rolePolicies' => function ($query) {
                $query->with(['policy'])->oldest('pid');
            },
        ])->first();
    }

    private function resolutionNavigations($navigations): Collection
    {
        $policies = $navigations->getRelation('rolePolicies');
        return $policies->filter(function ($policies) {
            return $policies->getRelation('policy')->getAttribute('type') == 'navigation';
        })->map(function ($policy) use ($policies) {
            $policies = $policies->filter(function ($policies) {
                return $policies->getRelation('policy')->getAttribute('type') == 'navigation';
            })->filter(function ($policies) use ($policy) {
                return $policies->getAttribute('pid') == $policy->getRelation('policy')->getAttribute('id');
            })->map(function ($policies) {
                return $policies->withoutRelations();
            });
            return $policy->getRelation('policy')->setRelation('policies', $policies);
        })->unique('id');
    }
}
