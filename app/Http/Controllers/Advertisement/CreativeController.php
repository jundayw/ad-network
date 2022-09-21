<?php

namespace App\Http\Controllers\Advertisement;

use App\Http\Requests\Advertisement\CreativeCreateRequest;
use App\Http\Requests\Advertisement\CreativeUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Advertisement\CreativeRepository;
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
     * @action 新增广告创意
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存广告创意
     */
    public function store(CreativeCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('advertisement.creative.list'));
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
        return new RenderResponse('操作成功', route('advertisement.creative.list'));
    }

    /**
     * @action 删除广告创意
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('advertisement.creative.list'));
    }
}
