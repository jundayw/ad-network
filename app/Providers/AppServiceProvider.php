<?php

namespace App\Providers;

use App\Models\Advertisement;
use App\Models\Publishment;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'advertisement' => Advertisement::class,
            'publishment' => Publishment::class,
        ]);
    }
}
