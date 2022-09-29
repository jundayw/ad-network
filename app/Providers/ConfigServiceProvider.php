<?php

namespace App\Providers;

use App\Models\System;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
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
        $system = cache()->rememberForever('system', function () {
            return with(new System(), function ($system) {
                return $system->select('key', 'value', 'type')->get()->mapWithKeys(function ($system) {
                    return [$system->key => $system->value];
                })->toArray();
            });
        });
        config([
            'adnetwork.system' => $system,
        ]);
    }
}
