<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Publisher;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AccountRepository extends Repository
{
    public function __construct(
        private readonly Publisher $publishment,
    )
    {
        //
    }

    public function login(Request $request)
    {
        $publishment = $this->publishment
            ->where('username', $request->get('username'))
            ->first();

        if (is_null($publishment)) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        if ($publishment->state == 'disable') {
            throw new RenderErrorResponseException('账户已被禁用');
        }

        if (strcasecmp($publishment->userpass, password($request->get('password'), $publishment->usersalt))) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        $publishment->update([
            'last_ip' => $request->getClientIp(),
            'last_time' => get_time(),
        ]);

        $this->guard('publisher')->login($publishment);
    }

    public function logout(Request $request)
    {
        $this->guard('publisher')->logout();
        app('request')->session()->invalidate();
    }

}
