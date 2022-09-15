<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace = "App\Http\Controllers";

    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::domain(config('domains.backend.domain'))
                ->namespace($this->namespace)
                ->middleware('web')
                ->group(base_path('routes/backend.php'));

            Route::domain(config('domains.advertisement.domain'))
                ->namespace($this->namespace)
                ->middleware('web')
                ->group(base_path('routes/advertisement.php'));

            Route::domain(config('domains.publishment.domain'))
                ->namespace($this->namespace)
                ->middleware('web')
                ->group(base_path('routes/publishment.php'));

            // Route::middleware('api')
            //     ->prefix('api')
            //     ->group(base_path('routes/api.php'));
            //
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
