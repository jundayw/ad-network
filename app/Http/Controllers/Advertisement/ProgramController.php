<?php

namespace App\Http\Controllers\Advertisement;

use App\Http\Requests\Advertisement\ProgramCreateRequest;
use App\Http\Requests\Advertisement\ProgramUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Advertisement\ProgramRepository;
use Illuminate\Http\Request;

/**
 * @module 广告计划
 * @controller 广告计划管理
 */
class ProgramController extends AuthController
{
    public function __construct(private readonly ProgramRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 广告计划列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增广告计划
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存广告计划
     */
    public function store(ProgramCreateRequest $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('advertisement.program.list'));
    }

    /**
     * @action 编辑广告计划
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新广告计划
     */
    public function update(ProgramUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('advertisement.program.list'));
    }

    /**
     * @action 删除广告计划
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('advertisement.program.list'));
    }
}
