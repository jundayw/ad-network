<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Requests\Publishment\SiteCreateRequest;
use App\Http\Requests\Publishment\SiteUpdateRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\SiteRepository;
use Illuminate\Http\Request;

/**
 * @module 站点
 * @controller 站点管理
 */
class SiteController extends AuthController
{
    public function __construct(private readonly SiteRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 站点列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增站点
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存站点
     */
    public function store(SiteCreateRequest $request): RenderResponse
    {
        return new RenderResponse('操作成功', route('publishment.site.verify', $this->repository->store($request)));
    }

    /**
     * @action 新增站点
     */
    public function verify(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->verify($request));
    }

    /**
     * @action 保存站点
     */
    public function verification(Request $request): RenderResponse
    {
        $this->repository->verification($request);
        return new RenderResponse('操作成功', route('publishment.site.list'));
    }

    public function download(Request $request)
    {
        return response()->streamDownload(function () use ($request) {
            echo $request->get('verify', 'verify');
        }, sprintf('%s.txt', $request->get('verification', 'verification')));
    }

    /**
     * @action 编辑站点
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新站点
     */
    public function update(SiteUpdateRequest $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('publishment.site.list'));
    }

    /**
     * @action 删除站点
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('publishment.site.list'));
    }
}
