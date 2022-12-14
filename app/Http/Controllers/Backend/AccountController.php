<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\AccountLoginRequest;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\AccountRepository;
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
        return new RedirectResponse('操作成功', route('backend.index'));
    }

    /**
     * @action 账户退出
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->repository->logout($request);
        return new RedirectResponse('安全退出', route('backend.login', ['code' => '100']));
    }
}
