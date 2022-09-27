<?php

namespace App\Repositories\Backend;

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
            ->withWhereHas('publishment', function ($query) use ($request) {
                $query->when($request->get('publishment'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('publishment')}%");
                });
            })
            ->when($request->get('username'), function ($query) use ($request) {
                $query->where('username', 'LIKE', "%{$request->get('username')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->publisher->getKeyName());

        $data = $data->Paginate($request->get('per', $this->publisher->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.publisher.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.publisher.destroy', [$items->getKeyName() => $items->getKey()]);
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
        return $this->role->withWhereHas('module', function ($query) {
            return $query->where('namespace', 'PUBLISHMENT');
        })->where('state', 'NORMAL')->get();
    }

    public function edit(Request $request): array
    {
        $data = $this->publisher->find($request->get($this->publisher->getKeyName()));

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
        $publisher = $this->publisher->find($request->get($this->publisher->getKeyName()));

        if (is_null($publisher)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $role = $this->role->find($request->get('role'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('角色参数有误');
        }

        $data = [
            'role_id' => $role->getAttribute('id'),
            'role_title' => $role->getAttribute('title'),
            'usernick' => $request->get('usernick'),
            'username' => $request->get('username'),
            'state' => $request->get('state'),
        ];

        if ($password = $request->get('password')) {
            $usersalt         = generate_string();
            $password         = password($password, $usersalt);
            $data['usersalt'] = $usersalt;
            $data['userpass'] = $password;
        }

        return $publisher->update($data);
    }

    public function destroy(Request $request): bool
    {
        return !($this->publisher->destroy($request->get($this->publisher->getKeyName())) === 0);
    }
}
