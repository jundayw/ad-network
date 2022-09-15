<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Manager;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AccountRepository extends Repository
{
    public function __construct(
        private readonly Manager $manager,
    )
    {
        //
    }

    public function login(Request $request)
    {
        $manager = $this->manager
            ->where('username', $request->get('username'))
            ->first();

        if (is_null($manager)) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        if ($manager->state == 'disable') {
            throw new RenderErrorResponseException('账户已被禁用');
        }

        if (strcasecmp($manager->userpass, password($request->get('password'), $manager->usersalt))) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        $manager->update([
            'last_ip' => $request->getClientIp(),
            'last_time' => get_time(),
        ]);

        $this->guard('manager')->login($manager);
    }

    public function logout(Request $request)
    {
        $this->guard('manager')->logout();
        app('request')->session()->invalidate();
    }

}
