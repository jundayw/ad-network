<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Advertiser;
use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AdvertiserRepository extends Repository
{
    public function __construct(
        private readonly Advertiser $advertiser,
        private readonly Role $role,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->advertiser
            ->withWhereHas('advertisement', function ($query) use ($request) {
                $query->when($request->get('advertisement'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('advertisement')}%");
                });
            })
            ->when($request->get('username'), function ($query) use ($request) {
                $query->where('username', 'LIKE', "%{$request->get('username')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->advertiser->getKeyName());

        $data = $data->Paginate($request->get('per', $this->advertiser->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.advertiser.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.advertiser.destroy', [$items->getKeyName() => $items->getKey()]);
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
        return $this->role->withWhereHas('module', function ($query) {
            return $query->where('namespace', 'ADVERTISEMENT');
        })->where('state', 'NORMAL')->get();
    }

    public function edit(Request $request): array
    {
        $data = $this->advertiser->find($request->get($this->advertiser->getKeyName()));

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
        $advertiser = $this->advertiser->find($request->get($this->advertiser->getKeyName()));

        if (is_null($advertiser)) {
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

        return $advertiser->update($data);
    }

    public function destroy(Request $request): bool
    {
        return !($this->advertiser->destroy($request->get($this->advertiser->getKeyName())) === 0);
    }
}
