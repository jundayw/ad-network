<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Manager;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ProfileRepository extends Repository
{
    public function __construct(
        private readonly Manager $manager,
    )
    {
        //
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

        $data = $this->manager->find($request->user()->getKey());

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'userpass' => $userpass,
            'usersalt' => $usersalt,
        ]);
    }
}
