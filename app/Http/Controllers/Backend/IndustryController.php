<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\IndustryCreateRequest;
use App\Http\Requests\Backend\IndustryUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\IndustryRepository;
use Illuminate\Http\Request;

/**
 * @module 行业
 * @controller 行业管理
 */
class IndustryController extends AuthController
{
    public function __construct(private readonly IndustryRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 行业列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增行业
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存行业
     */
    public function store(IndustryCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('backend.industry.list'));
    }

    /**
     * @action 编辑行业
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新行业
     */
    public function update(IndustryUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.industry.list'));
    }

    /**
     * @action 删除行业
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.industry.list'));
    }
}
