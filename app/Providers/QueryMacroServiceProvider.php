<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class QueryMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
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
        // SQL 执行语句监听
        DB::listen(function($query) {
            $sql             = str_replace("?", "'%s'", $query->sql);
            $query->bindings = array_map(function($binding) {
                if ($binding instanceof \DateTime) {
                    return $binding->format("Y-m-d H:i:s");
                } else if (is_string($binding)) {
                    return "{$binding}";
                }
                return $binding;
            }, $query->bindings);
            $log             = vsprintf($sql, $query->bindings);
            Log::channel('database')->info($log);
            Log::channel('database')->info(app('request')->getRequestUri() . PHP_EOL);
        });
        // 获取 Query 执行原始 SQL
        \Illuminate\Database\Query\Builder::macro('sql', function() {
            $sql = str_replace("?", "'%s'", $this->toSql());
            return vsprintf($sql, $this->getBindings());
        });
        // 获取 Eloquent 执行原始 SQL
        \Illuminate\Database\Eloquent\Builder::macro('sql', function() {
            return $this->getQuery()->sql();
        });
    }
}
