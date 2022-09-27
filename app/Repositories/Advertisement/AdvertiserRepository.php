<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Advertiser;
use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AdvertiserRepository extends Repository
{
    public function __construct(
        private readonly Advertiser $advertiser,
        private readonly Role $role
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->advertiser
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('role'), function ($query) use ($request) {
                $query->where('role_id', $request->get('role'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->advertisements($request)
            ->oldest('state')
            ->latest($this->advertiser->getKeyName());

        $data = $data->Paginate($request->get('per', $this->advertiser->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state    = $items->getState($items->state);
            $items->password = url()->signedRoute('advertisement.advertiser.password', [$items->getKeyName() => $items->getKey()]);
            $items->edit     = url()->signedRoute('advertisement.advertiser.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy  = url()->signedRoute('advertisement.advertiser.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'roles' => $this->getRoles(),
            'state' => $this->advertiser->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getRoles()
    {
        return $this->role->whereHas('module', function ($query) {
            $query->where('namespace', last(explode('\\', __NAMESPACE__)));
        })->where([
            'state' => 'NORMAL',
        ])->latest('sorting')->get();
    }

    public function create(Request $request): array
    {
        $filter = [
            'roles' => $this->getRoles(),
            'state' => $this->advertiser->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Advertiser
    {
        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $data = $this->advertiser->create([
            'advertisement_id' => $request->user()->getAttribute('advertisement_id'),
            'role_id' => $role->id,
            'role_title' => $role->title,
            'usernick' => $request->get('usernick'),
            'username' => $request->get('username'),
            'userpass' => $userpass,
            'usersalt' => $usersalt,
            'register_ip' => $request->getClientIp(),
            'register_time' => get_time(),
            'state' => $request->get('state'),
        ]);

        if (is_null($data)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $data;
    }

    public function edit(Request $request): array
    {
        $data = $this->advertiser->advertisements($request)->find($request->get($this->advertiser->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'roles' => $this->getRoles(),
            'state' => $this->advertiser->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $advertiser = $this->advertiser->advertisements($request)->find($request->get($this->advertiser->getKeyName()));

        if (is_null($advertiser)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        return $advertiser->update([
            'role_id' => $role->id,
            'role_title' => $role->title,
            'usernick' => $request->get('usernick'),
            'username' => $request->get('username'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $advertiser = $this->advertiser->advertisements($request)->find($request->get($this->advertiser->getKeyName()));
        if (is_null($advertiser)) {
            return false;
        }
        return $advertiser->delete();
    }

    public function password(Request $request): array
    {
        $data = $this->advertiser->advertisements($request)->find($request->get($this->advertiser->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [];

        return compact('filter', 'data');
    }

    public function updatePassword(Request $request): bool
    {
        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $data = $this->advertiser->advertisements($request)->find($request->get($this->advertiser->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'userpass' => $userpass,
            'usersalt' => $usersalt,
        ]);
    }
}
