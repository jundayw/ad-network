<?php

namespace App\Http\Controllers\Advertisement;

use App\Http\Requests\Advertisement\DepositRechargeRequest;
use App\Http\Requests\Advertisement\DepositWithdrawRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Advertisement\DepositRepository;
use Illuminate\Http\Request;

/**
 * @module 财务
 * @controller 财务管理
 */
class DepositController extends AuthController
{
    public function __construct(private readonly DepositRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 财务列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 充值
     */
    public function recharge(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->recharge($request));
    }

    /**
     * @action 保存财务
     */
    public function store(DepositRechargeRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('advertisement.deposit.list'));
    }

    /**
     * @action 提现
     */
    public function withdraw(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->withdraw($request));
    }

    /**
     * @action 更新财务
     */
    public function update(DepositWithdrawRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('advertisement.deposit.list'));
    }
}
