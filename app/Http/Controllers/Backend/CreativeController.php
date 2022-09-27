<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreativeUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\CreativeRepository;
use Illuminate\Http\Request;

/**
 * @module 广告创意
 * @controller 广告创意管理
 */
class CreativeController extends AuthController
{
    public function __construct(private readonly CreativeRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告创意列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑广告创意
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告创意
     */
    public function update(CreativeUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.creative.list'));
    }

    /**
     * @action 删除广告创意
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.creative.list'));
    }
}
