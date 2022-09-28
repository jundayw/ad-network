<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\PublishmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * @module 后台管理
 * @controller 后台首页
 */
class IndexController extends UnAuthController
{
    public function __construct(private readonly PublishmentRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 仪表板
     * @desc 欢迎回来！
     */
    public function index(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->index($request));
    }

    /**
     * @action 清除缓存
     */
    public function clear(Request $request): RenderResponse
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return new RenderResponse('操作成功', route('publishment.index'));
    }
}
