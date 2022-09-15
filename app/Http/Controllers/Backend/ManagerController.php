<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ManagerCreateRequest;
use App\Http\Requests\Backend\ManagerPasswordRequest;
use App\Http\Requests\Backend\ManagerUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\ManagerRepository;
use Illuminate\Http\Request;

/**
 * @module 管理员
 * @controller 管理员管理
 */
class ManagerController extends AuthController
{
    public function __construct(
        private readonly ManagerRepository $repository,
    )
    {
        parent::__construct();
    }

    /**
     * @action 管理员列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增管理员
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存管理员
     */
    public function store(ManagerCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.manager.list'));
    }

    /**
     * @action 编辑管理员
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新管理员
     */
    public function update(ManagerUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.manager.list'));
    }

    /**
     * @action 删除管理员
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('操作成功', route('backend.manager.list'));
    }

    /**
     * @action 重置密码
     */
    public function password(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->password($request));
    }

    /**
     * @action 重置密码
     */
    public function updatePassword(ManagerPasswordRequest $request): RenderResponse
    {
        $this->repository->updatePassword($request);
        return new RenderResponse('操作成功', route('backend.manager.list'));
    }
}
