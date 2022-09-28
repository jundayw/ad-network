<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\DepositCreateRequest;
use App\Http\Requests\Backend\DepositUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\DepositRepository;
use Illuminate\Http\Request;

/**
 * @module 资金管理
 * @controller 资金管理管理
 */
class DepositController extends AuthController
{
    public function __construct(private readonly DepositRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 资金管理列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 充值提现
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存资金管理
     */
    public function store(DepositCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', 'javascript:dialogClose();');
    }

    /**
     * @action 交易审核
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新资金管理
     */
    public function update(DepositUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', 'javascript:dialogClose();');
    }

    /**
     * @action 删除资金管理
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.deposit.list'));
    }
}
