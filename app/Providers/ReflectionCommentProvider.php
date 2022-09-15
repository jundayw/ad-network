<?php

namespace App\Providers;

use App\Support\Contracts\ReflectionCommentWhenResolved;
use Illuminate\Support\ServiceProvider;

class ReflectionCommentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->afterResolving(ReflectionCommentWhenResolved::class, function ($resolved) {
            $resolved->ReflectionCommentResolved();
        });
    }
}
