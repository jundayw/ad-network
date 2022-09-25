<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Requests\Publishment\MaterialCreateRequest;
use App\Http\Requests\Publishment\MaterialUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\MaterialRepository;
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
     * @action 新增广告物料
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存广告物料
     */
    public function store(MaterialCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('publishment.material.list'));
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
        return new RenderResponse('操作成功', route('publishment.material.list'));
    }

    /**
     * @action 删除广告物料
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('publishment.material.list'));
    }
}
