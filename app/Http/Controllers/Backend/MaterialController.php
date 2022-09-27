<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\MaterialUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\MaterialRepository;
use Illuminate\Http\Request;

/**
 * @module 广告物料
 * @controller 广告物料管理
 */
class MaterialController extends AuthController
{
    public function __construct(private readonly MaterialRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告物料列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑广告物料
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告物料
     */
    public function update(MaterialUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.material.list'));
    }

    /**
     * @action 删除广告物料
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.material.list'));
    }
}
