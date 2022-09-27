<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ElementUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\ElementRepository;
use Illuminate\Http\Request;

/**
 * @module 广告单元
 * @controller 广告单元管理
 */
class ElementController extends AuthController
{
    public function __construct(private readonly ElementRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告单元列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑广告单元
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告单元
     */
    public function update(ElementUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.element.list'));
    }

    /**
     * @action 删除广告单元
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.element.list'));
    }
}
