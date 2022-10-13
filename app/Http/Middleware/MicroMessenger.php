<?php

namespace App\Http\Middleware;

use App\Exceptions\RenderErrorResponseException;
use Closure;
use Illuminate\Http\Request;

class MicroMessenger
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (strripos($request->userAgent(), 'MicroMessenger')) {
            throw new RenderErrorResponseException('请使用系统默认浏览器打开', $request->getUri());
        }

        return $next($request);
    }
}
