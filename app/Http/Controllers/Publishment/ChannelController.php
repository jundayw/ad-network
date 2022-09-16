<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Requests\Publishment\ChannelCreateRequest;
use App\Http\Requests\Publishment\ChannelUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\ChannelRepository;
use Illuminate\Http\Request;

/**
 * @module 频道
 * @controller 频道管理
 */
class ChannelController extends AuthController
{
    public function __construct(private readonly ChannelRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 频道列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增频道
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存频道
     */
    public function store(ChannelCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('publishment.channel.list'));
    }

    /**
     * @action 编辑频道
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新频道
     */
    public function update(ChannelUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('publishment.channel.list'));
    }

    /**
     * @action 删除频道
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('publishment.channel.list'));
    }
}
