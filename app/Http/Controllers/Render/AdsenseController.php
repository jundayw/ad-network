<?php

namespace App\Http\Controllers\Render;

use App\Http\Responses\ViewResponse;
use App\Repositories\Render\AdsenseRepository;
use Illuminate\Http\Request;

class AdsenseController extends BaseController
{
    public function __construct(private readonly AdsenseRepository $repository)
    {
        parent::__construct();
    }

    public function network(Request $request): ViewResponse
    {
        $repository = $this->repository->network($request);
        return new ViewResponse($repository->getWith(), $repository->getView());
    }

    public function render(Request $request): ViewResponse
    {
        $repository = $this->repository->render($request);
        return new ViewResponse($repository->getWith(), $repository->getView());
    }
}
