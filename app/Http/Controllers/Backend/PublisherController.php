<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PublisherUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\PublisherRepository;
use Illuminate\Http\Request;

/**
 * @module 流量主账户
 * @controller 流量主账户管理
 */
class PublisherController extends AuthController
{
    public function __construct(private readonly PublisherRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 流量主账户列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 编辑流量主账户
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新流量主账户
     */
    public function update(PublisherUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('backend.publisher.list'));
    }

    /**
     * @action 删除流量主账户
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.publisher.list'));
    }
}
