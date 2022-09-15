<?php

namespace App\Extensions\Auth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;

class SessionCacheGuard extends SessionGuard
{
    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        return session()->remember(static::class, function() {
            return $this->user = parent::user();
        });
    }
}
