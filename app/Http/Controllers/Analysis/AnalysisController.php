<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Responses\RenderResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnalysisController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function review(Request $request): RenderResponse
    {
        return new RenderResponse();
    }

    public function redirect(Request $request): RedirectResponse
    {
        return response()->redirectTo('https://www.baidu.com');
    }
}
