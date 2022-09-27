<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ProgramUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\ProgramRepository;
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
        return new RenderResponse('操作成功', route('backend.program.list'));
    }

    /**
     * @action 删除广告计划
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('backend.program.list'));
    }
}
