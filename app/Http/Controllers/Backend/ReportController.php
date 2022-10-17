<?php

namespace App\Http\Controllers\Backend;

use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\ReportRepository;
use Illuminate\Http\Request;

/**
 * @module 报告
 * @controller 报告管理
 */
class ReportController extends AuthController
{
    public function __construct(private readonly ReportRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 报告列表
     */
    public function visits(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->visits($request));
    }

    /**
     * @action 报告列表
     */
    public function visitant(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->visitant($request));
    }

    /**
     * @action 报告列表
     */
    public function vacation(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->vacation($request));
    }
}
