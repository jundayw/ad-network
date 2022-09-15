<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Advertiser;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AccountRepository extends Repository
{
    public function __construct(
        private readonly Advertiser $advertisement,
    )
    {
        //
    }

    public function login(Request $request)
    {
        $advertisement = $this->advertisement
            ->where('username', $request->get('username'))
            ->first();

        if (is_null($advertisement)) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        if ($advertisement->state == 'disable') {
            throw new RenderErrorResponseException('账户已被禁用');
        }

        if (strcasecmp($advertisement->userpass, password($request->get('password'), $advertisement->usersalt))) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        $advertisement->update([
            'last_ip' => $request->getClientIp(),
            'last_time' => get_time(),
        ]);

        $this->guard('advertiser')->login($advertisement);
    }

    public function logout(Request $request)
    {
        $this->guard('advertiser')->logout();
        app('request')->session()->invalidate();
    }

}
