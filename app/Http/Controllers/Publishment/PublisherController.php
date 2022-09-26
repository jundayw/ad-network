<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Requests\Publishment\PublisherCreateRequest;
use App\Http\Requests\Publishment\PublisherPasswordRequest;
use App\Http\Requests\Publishment\PublisherUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\PublisherRepository;
use Illuminate\Http\Request;

/**
 * @module 账户管理
 * @controller 账户管理管理
 */
class PublisherController extends AuthController
{
    public function __construct(private readonly PublisherRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 账户管理列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增账户管理
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存账户管理
     */
    public function store(PublisherCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('publishment.publisher.list'));
    }

    /**
     * @action 编辑账户管理
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新账户管理
     */
    public function update(PublisherUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('publishment.publisher.list'));
    }

    /**
     * @action 删除账户管理
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('publishment.publisher.list'));
    }

    /**
     * @action 重置密码
     */
    public function password(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->password($request));
    }

    /**
     * @action 重置密码
     */
    public function updatePassword(PublisherPasswordRequest $request): RenderResponse
    {
        $this->repository->updatePassword($request);
        return new RenderResponse('操作成功', route('publishment.publisher.list'));
    }
}
