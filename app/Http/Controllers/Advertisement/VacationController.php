<?php

namespace App\Http\Controllers\Advertisement;

use App\Http\Responses\ViewResponse;
use App\Repositories\Advertisement\VacationRepository;
use Illuminate\Http\Request;

/**
 * @module 报告
 * @controller 报告管理
 */
class VacationController extends AuthController
{
    public function __construct(private readonly VacationRepository $repository)
    {
        parent::__construct();
    }

    /**
     * @action 报告列表
     */
    public function list(Request $request): ViewResponse
    {
        return new ViewResponse($this->repository->list($request));
    }
}
