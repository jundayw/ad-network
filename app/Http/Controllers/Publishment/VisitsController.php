<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\VisitsRepository;
use Illuminate\Http\Request;

/**
 * @module 空闲报告
 * @controller 空闲报告管理
 */
class VisitsController extends AuthController
{
    public function __construct(private readonly VisitsRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 空闲报告列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }
}
