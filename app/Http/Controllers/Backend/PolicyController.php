<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PolicyCreateRequest;
use App\Http\Requests\Backend\PolicyUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\PolicyRepository;
use Illuminate\Http\Request;

/**
 * @module 策略
 * @controller 策略管理
 */
class PolicyController extends AuthController
{
    public function __construct(
        private readonly PolicyRepository $repository,
    )
    {
        parent::__construct();
    }

    /**
     * @action 策略列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增策略
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存策略
     */
    public function store(PolicyCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.policy.list'));
    }

    /**
     * @action 编辑策略
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新策略
     */
    public function update(PolicyUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.policy.list'));
    }

    /**
     * @action 删除策略
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('操作成功', route('backend.policy.list'));
    }
}
