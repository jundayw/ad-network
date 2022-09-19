<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Requests\Publishment\AdsenseCreateRequest;
use App\Http\Requests\Publishment\AdsenseUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\AdsenseRepository;
use Illuminate\Http\Request;

/**
 * @module 广告位
 * @controller 广告位管理
 */
class AdsenseController extends AuthController
{
    public function __construct(private readonly AdsenseRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告位列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增广告位
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存广告位
     */
    public function store(AdsenseCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('publishment.adsense.list'));
    }

    /**
     * @action 编辑广告位
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告位
     */
    public function update(AdsenseUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('publishment.adsense.list'));
    }

    /**
     * @action 删除广告位
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('publishment.adsense.list'));
    }
}
