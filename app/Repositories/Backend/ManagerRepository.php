<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Manager;
use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ManagerRepository extends Repository
{
    public function __construct(
        private readonly Manager $manager,
        private readonly Role $role,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->manager
            ->when($request->get('role'), function ($query) use ($request) {
                $query->where('role_id', $request->get('role'));
            })
            ->when($request->get('usernick'), function ($query) use ($request) {
                $query->where('usernick', 'LIKE', "%{$request->get('usernick')}%");
            })
            ->when($request->get('username'), function ($query) use ($request) {
                $query->where('username', 'LIKE', "%{$request->get('username')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->manager->getKeyName());

        $data = $data->Paginate($request->get('per', $this->manager->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state    = $items->getState($items->state);
            $items->password = route('backend.manager.password', [$items->getKeyName() => $items->getKey()]);
            $items->edit     = route('backend.manager.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy  = route('backend.manager.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $roles = $this->role
            ->with([
                'module',
            ])
            ->oldest('module_id')
            ->oldest('state')
            ->latest('sorting')
            ->get();

        $filter = [
            'roles' => $roles,
            'states' => $this->manager->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $roles = $this->role
            ->with([
                'module',
            ])
            ->where('state', 'NORMAL')
            ->oldest('module_id')
            ->oldest('state')
            ->latest('sorting')
            ->get();

        $filter = [
            'roles' => $roles,
            'states' => $this->manager->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Manager
    {
        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $data = $this->manager->create([
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
        $data = $this->manager->find($request->get($this->manager->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $roles = $this->role
            ->with([
                'module',
            ])
            ->where('state', 'NORMAL')
            ->oldest('module_id')
            ->oldest('state')
            ->latest('sorting')
            ->get();

        $filter = [
            'roles' => $roles,
            'states' => $this->manager->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $data = $this->manager->find($request->get($this->manager->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        return $data->update([
            'role_id' => $role->id,
            'role_title' => $role->title,
            'usernick' => $request->get('usernick'),
            'username' => $request->get('username'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->manager->destroy($request->get($this->manager->getKeyName())) === 0);
    }

    public function password(Request $request): array
    {
        $data = $this->manager->find($request->get($this->manager->getKeyName()));

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

        $data = $this->manager->find($request->get($this->manager->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'userpass' => $userpass,
            'usersalt' => $usersalt,
        ]);
    }
}
