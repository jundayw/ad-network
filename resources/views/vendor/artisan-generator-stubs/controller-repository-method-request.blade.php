<?php

namespace DummyNamespace;

use DummyRequestClass1Namespace;
use DummyRequestClass2Namespace;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use DummyRepositoryClassNamespace;
use Illuminate\Http\Request;

/**
 * @module DummyLabel
 * @controller DummyLabel管理
 */
class DummyControllerClass extends AuthController
{
    public function __construct(private readonly DummyRepositoryClass $repository)
    {
        parent::__construct();
    }

    /**
     * @action DummyLabel列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }

    /**
     * @action 新增DummyLabel
     */
    public function create(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->create($request));
    }

    /**
     * @action 保存DummyLabel
     */
    public function store(DummyRequestClass1 $request): RenderResponse
    {
        $this->repository->store($request);
        return new RenderResponse('操作成功', route('DummyViewVariableList'));
    }

    /**
     * @action 编辑DummyLabel
     */
    public function edit(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->edit($request));
    }

    /**
     * @action 更新DummyLabel
     */
    public function update(DummyRequestClass2 $request): RenderResponse
    {
        $this->repository->update($request);
        return new RenderResponse('操作成功', route('DummyViewVariableList'));
    }

    /**
     * @action 删除DummyLabel
     */
    public function destroy(Request $request): RenderResponse
    {
        $this->repository->destroy($request);
        return new RenderResponse('删除成功', route('DummyViewVariableList'));
    }
}
