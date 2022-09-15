<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RoleCreateRequest;
use App\Http\Requests\Backend\RoleUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\RoleRepository;
use Illuminate\Http\Request;

/**
 * @module 角色
 * @controller 角色管理
 */
class RoleController extends AuthController
{
    public function __construct(private readonly RoleRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 角色列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增角色
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存角色
     */
    public function store(RoleCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.role.list'));
    }

    /**
     * @action 编辑角色
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新角色
     */
    public function update(RoleUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.role.list'));
    }

    /**
     * @action 删除角色
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('操作成功', route('backend.role.list'));
    }
}
