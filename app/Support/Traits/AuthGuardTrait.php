<?php

namespace App\Support\Traits;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;

trait AuthGuardTrait
{
    public function guard($guard = ''): Guard|StatefulGuard
    {
        return Auth::guard($guard);
    }
}
