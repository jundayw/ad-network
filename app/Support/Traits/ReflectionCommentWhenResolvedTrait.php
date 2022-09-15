<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\View;

trait ReflectionCommentWhenResolvedTrait
{
    public function ReflectionCommentResolved(): void
    {
        $data = [
            'module' => $this->getClassDocCommentByParam('@module', 'unknown module'),
            'controller' => $this->getClassDocCommentByParam('@controller', 'unknown controller'),
            'action' => $this->getMethodDocCommentByParam('@action', 'unknown action'),
            'desc' => $this->getMethodDocCommentByParam('@desc'),
        ];

        $data['dns-prefetch'] = config('helpers.assets.dns-prefetch');
        $data['url']          = $this->getNamespaceControllerActionName();

        $share = $this->getClassDocCommentByParam('@share', 'share');

        View::share($share, collect($data));
    }

    /**
     * 获取类注释参数
     * @param string $parameter
     * @param string|null $default
     * @return string|null
     */
    private function getClassDocCommentByParam(string $parameter, string $default = null): ?string
    {
        $class = new \ReflectionClass($this);

        $docComment = $class->getDocComment();

        if ($docComment === false) {
            return $default;
        }

        $result = $this->docCommentParse($docComment, $parameter);

        if ($result === false) {
            $result = $default;
        }

        return $result;
    }

    /**
     * 获取类方法注释参数
     * @param string $parameter
     * @param string|null $default
     * @param boolean $method
     * @return string|null
     * @throws \ReflectionException
     */
    private function getMethodDocCommentByParam(string $parameter, string $default = null, bool $method = true): ?string
    {
        if (app()->runningInConsole()) {
            return null;
        }

        $class = new \ReflectionClass($this);

        if ($method === true) {
            $method = app('request')->route()->getActionMethod();
        }

        if (method_exists($this, $method) === false) {
            return $default;
        }

        $method = $class->getMethod($method);

        $docComment = $method->getDocComment();

        if ($docComment === false) {
            return $default;
        }

        $result = $this->docCommentParse($docComment, $parameter);

        if ($result === false) {
            $result = $default;
        }

        return $result;
    }

    /**
     * 解析注释
     * @param string $docComment
     * @param string $parameter
     * @return string|boolean
     */
    private function docCommentParse(string $docComment, string $parameter): bool|string
    {
        foreach ($docblock = explode(PHP_EOL, $docComment) as $key => $item) {
            if ($offset = strpos($item, $parameter)) {
                return trim(substr($item, $offset + strlen($parameter)));
            }
        }

        return false;
    }

}
