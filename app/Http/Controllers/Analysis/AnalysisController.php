<?php

namespace App\Http\Controllers\Analysis;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnalysisController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function review(Request $request): Response
    {
        return response(
            content: base64_decode('R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=')
        )->header('Content-Type', 'image/gif');
    }

    public function redirect(Request $request): RedirectResponse
    {
        return response()->redirectTo('https://www.baidu.com');
    }
}
