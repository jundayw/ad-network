<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\AdvertiserUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\AdvertiserRepository;
use Illuminate\Http\Request;

/**
 * @module 广告主账户
 * @controller 广告主账户管理
 */
class AdvertiserController extends AuthController
{
    public function __construct(private readonly AdvertiserRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告主账户列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑广告主账户
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告主账户
     */
    public function update(AdvertiserUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.advertiser.list'));
    }

    /**
     * @action 删除广告主账户
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.advertiser.list'));
    }
}
