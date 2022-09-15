<?php

namespace App\Services\Backend;

use Illuminate\Support\Facades\Route;

class PolicyService
{
    public function getRoutesNames(): array
    {
        $routeNameList = Route::getRoutes()->getRoutesByName();
        return collect($routeNameList)
            ->where(function($route, $key) {
                $uses = $route->getAction('uses');
                if ($uses instanceof \Closure) {
                    return false;
                }
                $middlewares = $route->getAction('middleware');
                if (is_string($middlewares)) {
                    return false;
                }
                foreach ($middlewares as $middleware) {
                    return in_array($middleware, ['web', 'policies']);
                }
            })
            ->map(function($route, $key) {
                return [
                    'url' => $key,
                    'namespace' => $route->getAction('namespace'),
                    'action' => $route->getAction(null),
                ];
            })
            ->groupBy(['namespace'], true)
            ->toArray();
    }
}
