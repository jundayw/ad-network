<?php

namespace App\Providers;

use App\Extensions\Auth\SessionCacheGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class SessionCacheGuardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        Auth::extend('cache', function($app, $name, $config) {
            $guard = new SessionCacheGuard(
                $name,
                Auth::createUserProvider($config['provider'] ?? null),
                $app['session.store']
            );

            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            if (isset($config['remember'])) {
                $guard->setRememberDuration($config['remember']);
            }

            return $guard;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
