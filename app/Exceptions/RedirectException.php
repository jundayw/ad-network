<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Jundayw\LaravelRenderProvider\Support\Facades\Render;
use RuntimeException;

class RedirectException extends RuntimeException implements Responsable
{
    public function __construct(
        protected string  $error = '',
        protected ?string $url = null,
        protected array   $errors = []
    )
    {
        parent::__construct($error);
    }

    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            return Render::error($this->error, $this->url, $this->errors)->response();
        }

        return redirect()
            ->to($this->url)
            ->withInput()
            ->withMessage($this->error)
            ->with($this->errors);
    }

}
