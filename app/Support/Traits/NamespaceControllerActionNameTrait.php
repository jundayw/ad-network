<?php

namespace App\Support\Traits;

trait NamespaceControllerActionNameTrait
{
    /**
     * @param string $delimiter
     * @return string|null
     */
    public function getNamespaceControllerActionName(string $delimiter = '.'): ?string
    {
        if (app()->runningInConsole()) {
            return null;
        }

        $controller = app('request')->route()->getAction('controller');

        $controller = array_map(function($item) {
            return strtolower($item);
        }, array_slice(explode('\\', str_replace('Controller@', '\\', $controller)), 3));

        return implode($delimiter, $controller);
    }
}
