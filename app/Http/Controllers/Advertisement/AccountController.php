<?php

namespace App\Http\Controllers\Advertisement;

use App\Http\Requests\Advertisement\AccountLoginRequest;
use App\Http\Requests\Advertisement\AccountMailRequest;
use App\Http\Requests\Advertisement\AccountRegisterRequest;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Advertisement\AccountRepository;
use Illuminate\Http\Request;

/**
 * @module 登录
 * @controller 登录管理
 */
class AccountController extends UnCommonController
{
    public function __construct(
        private readonly AccountRepository $repository,
    )
    {
        parent::__construct();
    }

    /**
     * @action 账户登录
     */
    public function login(Request $request): ViewResponse
    {
        $code    = $request->get('code', 200);
        $message = match (intval($code)) {
            100 => '安全退出',
            200 => '账户登录',
            401 => '登录已超时，请重新登录',
            default => '未知状态码',
        };
        return new ViewResponse(compact('message'));
    }

    /**
     * @action 账户登录
     */
    public function verify(AccountLoginRequest $request): RedirectResponse
    {
        $this->repository->login($request);
        return new RedirectResponse('操作成功', route('advertisement.index'));
    }

    /**
     * @action 账户退出
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->repository->logout($request);
        return new RedirectResponse('安全退出', route('advertisement.login', ['code' => '100']));
    }

    /**
     * @action 账户注册
     */
    public function signup(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->signup($request));
    }

    /**
     * @action 账户注册
     */
    public function register(AccountRegisterRequest $request): RedirectResponse
    {
        $this->repository->register($request);
        return new RedirectResponse('注册成功', route('advertisement.login', ['code' => '200']));
    }

    /**
     * @action 邮件发送
     */
    public function mail(AccountMailRequest $request): RenderResponse
    {
        $this->repository->mail($request);
        return new RenderResponse('发送成功');
    }
}
