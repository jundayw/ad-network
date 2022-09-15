<?php

namespace App\Http\Controllers;

use App\Support\Contracts\ReflectionCommentWhenResolved;
use App\Support\Traits\NamespaceControllerActionNameTrait;
use App\Support\Traits\ReflectionCommentWhenResolvedTrait;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController implements ReflectionCommentWhenResolved
{
    use NamespaceControllerActionNameTrait, ReflectionCommentWhenResolvedTrait;

    public function __construct()
    {
        View::share('request', app('request'));
    }
}
