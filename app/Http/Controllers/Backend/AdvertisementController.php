<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\AdvertisementUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\AdvertisementRepository;
use Illuminate\Http\Request;

/**
 * @module 广告主
 * @controller 广告主管理
 */
class AdvertisementController extends AuthController
{
    public function __construct(private readonly AdvertisementRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告主列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑广告主
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告主
     */
    public function update(AdvertisementUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.advertisement.list'));
    }

    /**
     * @action 删除广告主
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.advertisement.list'));
    }
}
