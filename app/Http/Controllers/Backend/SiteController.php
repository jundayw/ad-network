<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\SiteUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\SiteRepository;
use Illuminate\Http\Request;

/**
 * @module 站点
 * @controller 站点管理
 */
class SiteController extends AuthController
{
    public function __construct(private readonly SiteRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 站点列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑站点
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新站点
     */
    public function update(SiteUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.site.list'));
    }

    /**
     * @action 删除站点
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.site.list'));
    }
}
