<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\SizeCreateRequest;
use App\Http\Requests\Backend\SizeUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\SizeRepository;
use Illuminate\Http\Request;

/**
 * @module 广告尺寸
 * @controller 广告尺寸管理
 */
class SizeController extends AuthController
{
    public function __construct(private readonly SizeRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告尺寸列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增广告尺寸
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存广告尺寸
     */
    public function store(SizeCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.size.list'));
    }

    /**
     * @action 编辑广告尺寸
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告尺寸
     */
    public function update(SizeUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.size.list'));
    }

    /**
     * @action 删除广告尺寸
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.size.list'));
    }
}
