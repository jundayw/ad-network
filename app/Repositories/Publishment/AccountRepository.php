<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Publisher;
use App\Models\Publishment;
use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountRepository extends Repository
{
    public function __construct(
        private readonly Publisher $publisher,
        private readonly Publishment $publishment,
        private readonly Role $role,
    )
    {
        //
    }

    public function login(Request $request)
    {
        $publisher = $this->publisher
            ->where('username', $request->get('username'))
            ->first();

        if (is_null($publisher)) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        if ($publisher->state == 'disable') {
            throw new RenderErrorResponseException('账户已被禁用');
        }

        if (strcasecmp($publisher->userpass, password($request->get('password'), $publisher->usersalt))) {
            throw new RenderErrorResponseException('用户名或密码有误');
        }

        $publisher->update([
            'last_ip' => $request->getClientIp(),
            'last_time' => get_time(),
        ]);

        $this->guard('publisher')->login($publisher);
    }

    public function logout(Request $request)
    {
        $this->guard('publisher')->logout();
        app('request')->session()->invalidate();
    }

    public function signup(Request $request): array
    {
        $filter = [
            'type' => $this->publishment->getType(),
        ];

        return compact('filter');
    }

    public function register(Request $request)
    {
        $email = session($request->get('email'));

        if (strcasecmp($email, $request->get('code'))) {
            throw new RenderErrorResponseException('邮箱验证码无效');
        }

        $role = $this->role->find(config('adnetwork.role.publishment'));

        if (is_null($role)) {
            throw new RenderErrorResponseException('默认角色组异常');
        }

        DB::beginTransaction();
        $publishment = $this->publishment->create([
            'type' => $request->get('type'),
            'audit' => 'INIT',
            'state' => 'NORMAL',
        ]);

        if (is_null($publishment)) {
            DB::rollBack();
            throw new RenderErrorResponseException('新增主体信息失败');
        }

        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $publisher = $this->publisher->create([
            'publishment_id' => $publishment->getKey(),
            'role_id' => $role->getAttribute('id'),
            'role_title' => $role->getAttribute('title'),
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

        return $publisher;
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
