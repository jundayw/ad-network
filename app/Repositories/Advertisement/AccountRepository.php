<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Advertisement;
use App\Models\Advertiser;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountRepository extends Repository
{
    public function __construct(
        private readonly Advertiser $advertiser,
        private readonly Advertisement $advertisement,
    )
    {
        //
    }

    public function login(Request $request)
    {
        $advertiser = $this->advertiser
            ->where('username', $request->get('username'))
            ->first();

        if (is_null($advertiser)) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        if ($advertiser->state == 'disable') {
            throw new RenderErrorResponseException('账户已被禁用');
        }

        if (strcasecmp($advertiser->userpass, password($request->get('password'), $advertiser->usersalt))) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        $advertiser->update([
            'last_ip' => $request->getClientIp(),
            'last_time' => get_time(),
        ]);

        $this->guard('advertiser')->login($advertiser);
    }

    public function logout(Request $request)
    {
        $this->guard('advertiser')->logout();
        app('request')->session()->invalidate();
    }

    public function signup(Request $request): array
    {
        $filter = [
            'type' => $this->advertisement->getType(),
        ];

        return compact('filter');
    }

    public function register(Request $request)
    {
        $email = session($request->get('email'));

        if (strcasecmp($email, $request->get('code'))) {
            throw new RenderErrorResponseException('邮箱验证码无效');
        }

        DB::beginTransaction();
        $advertisement = $this->advertisement->create([
            'type' => $request->get('type'),
            'audit' => 'INIT',
            'state' => 'NORMAL',
        ]);

        if (is_null($advertisement)) {
            DB::rollBack();
            throw new RenderErrorResponseException('新增主体信息失败');
        }

        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $advertiser = $this->advertiser->create([
            'advertisement_id' => $advertisement->getKey(),
            'role_id' => 4,
            'role_title' => '@todo',
            'usernick' => $request->get('username'),
            'username' => $request->get('username'),
            'userpass' => $userpass,
            'usersalt' => $usersalt,
            'mail' => $request->get('mail'),
            'register_ip' => $request->getClientIp(),
            'register_time' => get_time(),
            'state' => 'NORMAL',
        ]);
        DB::commit();

        return $advertiser;
    }

    public function mail(Request $request)
    {
        $email = $request->get('email');

        $code = generate_number();

        session([
            $email => $code,
        ]);

        Mail::to($email)->send(new \App\Mail\Verification\Mail($code));
    }

}
