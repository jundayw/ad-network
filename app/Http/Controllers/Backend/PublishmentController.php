<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PublishmentUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\PublishmentRepository;
use Illuminate\Http\Request;

/**
 * @module 流量主
 * @controller 流量主管理
 */
class PublishmentController extends AuthController
{
    public function __construct(private readonly PublishmentRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 流量主列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑流量主
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新流量主
     */
    public function update(PublishmentUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.publishment.list'));
    }

    /**
     * @action 删除流量主
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.publishment.list'));
    }
}
