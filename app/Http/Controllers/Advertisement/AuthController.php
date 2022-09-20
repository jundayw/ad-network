<?php

namespace App\Http\Controllers\Advertisement;

use App\Http\Responses\RedirectResponse;

class AuthController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('policy');
        // 账户认证判断中间件
        $this->middleware(function ($request, $next) {
            if (session()->has('audit')) {
                $audit = session('audit');
            } else {
                $audit = $request->user()->load('advertisement')->getRelation('advertisement')->getAttribute('audit');
            }
            if (strcasecmp($audit, 'success')) {
                return new RedirectResponse('认证', route('advertisement.profile.info'));
            }
            session(['audit' => 'success']);
            return $next($request);
        });
    }
}
