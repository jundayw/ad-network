<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ModuleCreateRequest;
use App\Http\Requests\Backend\ModuleUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\ModuleRepository;
use Illuminate\Http\Request;

/**
 * @module 模块管理
 * @controller 模块管理
 */
class ModuleController extends AuthController
{
    public function __construct(private readonly ModuleRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 模块列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增模块
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存模块
     */
    public function store(ModuleCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.module.list'));
    }

    /**
     * @action 编辑模块
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新模块
     */
    public function update(ModuleUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.module.list'));
    }

    /**
     * @action 删除模块
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('操作成功', route('backend.module.list'));
    }
}
