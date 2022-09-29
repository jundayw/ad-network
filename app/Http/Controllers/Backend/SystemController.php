<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\SystemCreateRequest;
use App\Http\Requests\Backend\SystemUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\SystemRepository;
use Illuminate\Http\Request;

/**
 * @module 系统配置
 * @controller 系统配置管理
 */
class SystemController extends AuthController
{
    public function __construct(private readonly SystemRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 系统配置列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增系统配置
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存系统配置
     */
    public function store(SystemCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.system.list'));
    }

    /**
     * @action 编辑系统配置
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新系统配置
     */
    public function update(SystemUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.system.list'));
    }

    /**
     * @action 删除系统配置
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.system.list'));
    }
}
