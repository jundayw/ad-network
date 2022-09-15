<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Jundayw\LaravelRenderProvider\Support\Facades\Render;
use RuntimeException;

class RenderErrorResponseException extends RuntimeException implements Responsable
{
    public function __construct(
        protected string  $error = '',
        protected ?string $url = null,
        protected array   $errors = [],
        protected ?string $view = null
    )
    {
        parent::__construct($error);
    }

    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            return Render::error($this->error, $this->url, $this->errors)->response();
        }

        return view($this->getViewName(config('view.dispatch.error')))
            ->withMessage($this->error)
            ->withUrl($this->url)
            ->with($this->errors);
    }

    protected function getViewName(string $view): string
    {
        if ($this->view) {
            return $this->view;
        }
        // 全局模板
        $view = config($view);
        // 获取当前模块
        $namespace     = app('request')->route()->getAction('namespace');
        $namespace     = strtolower(last(explode('\\', $namespace)));
        $namespaceView = join('.', [$namespace, $view]);
        // 优先使用当前模块下的模板
        if (view()->exists($namespaceView)) {
            return $namespaceView;
        }
        // 当前模块模板不存在使用全局模板
        return $view;
    }

}
