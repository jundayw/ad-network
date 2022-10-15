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
        $url        = base64_encode(rc4(config('app.key'), $repository->get('path')));
        return response()->redirectToRoute('analysis.analysis.location', compact('url'));
    }

    public function location(Request $request): RedirectResponse
    {
        $path = rc4(config('app.key'), base64_decode($request->get('url')));
        return response()->redirectTo($path);
    }
}
