<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Publisher;
use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class PublisherRepository extends Repository
{
    public function __construct(
        private readonly Publisher $publisher,
        private readonly Role $role,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->publisher
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('role'), function ($query) use ($request) {
                $query->where('role_id', $request->get('role'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->publishments($request)
            ->oldest('state')
            ->latest($this->publisher->getKeyName());

        $data = $data->Paginate($request->get('per', $this->publisher->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state    = $items->getState($items->state);
            $items->password = url()->signedRoute('publishment.publisher.password', [$items->getKeyName() => $items->getKey()]);
            $items->edit     = url()->signedRoute('publishment.publisher.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy  = url()->signedRoute('publishment.publisher.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'roles' => $this->getRoles(),
            'state' => $this->publisher->getState(),
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
            'state' => $this->publisher->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Publisher
    {
        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $data = $this->publisher->create([
            'publishment_id' => $request->user()->getAttribute('publishment_id'),
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
        $data = $this->publisher->publishments($request)->find($request->get($this->publisher->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'roles' => $this->getRoles(),
            'state' => $this->publisher->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $publisher = $this->publisher->publishments($request)->find($request->get($this->publisher->getKeyName()));

        if (is_null($publisher)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        return $publisher->update([
            'role_id' => $role->id,
            'role_title' => $role->title,
            'usernick' => $request->get('usernick'),
            'username' => $request->get('username'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $publisher = $this->publisher->publishments($request)->find($request->get($this->publisher->getKeyName()));
        if (is_null($publisher)) {
            return false;
        }
        return $publisher->delete();
    }

    public function password(Request $request): array
    {
        $data = $this->publisher->publishments($request)->find($request->get($this->publisher->getKeyName()));

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

        $data = $this->publisher->publishments($request)->find($request->get($this->publisher->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'userpass' => $userpass,
            'usersalt' => $usersalt,
        ]);
    }
}
