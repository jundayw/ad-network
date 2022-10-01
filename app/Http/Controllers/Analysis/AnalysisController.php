<?php

namespace App\Http\Controllers\Analysis;

use App\Repositories\Analysis\AnalysisRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnalysisController extends BaseController
{
    public function __construct(private readonly AnalysisRepository $repository)
    {
        parent::__construct();
    }

    public function review(Request $request): Response
    {
        $this->repository->review($request);
        return response(
            content: base64_decode('R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=')
        )->header('Content-Type', 'image/gif');
    }

    public function redirect(Request $request): RedirectResponse
    {
        $repository = $this->repository->redirect($request);
        return response()->redirectTo(
            path: $repository->get('path'),
            headers: $repository->get('headers')
        );
    }
}
