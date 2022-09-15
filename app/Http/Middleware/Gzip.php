<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Gzip
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
        $response = $next($request);

        if (config('helpers.gzip') === false) {
            return $response;
        }

        $html    = $response->getContent();
        $search  = [
            chr(8),// 回格
            chr(9),// tab(水平制表符)
            chr(10),// 换行
            chr(11),// tab(垂直制表符)
            chr(12),// 换页
            chr(13),// 回车 chr(13)&chr(10) 回车和换行的组合
            chr(32) . chr(32),// 空格
        ];
        $replace = '';// 空字符
        $html    = str_replace($search, $replace, $html);

        return $response->setContent($html);
    }
}
