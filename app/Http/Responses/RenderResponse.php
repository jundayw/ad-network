<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Jundayw\LaravelRenderProvider\Support\Facades\Render;

class RenderResponse implements Responsable
{
    public function __construct(
        protected string  $message = '',
        protected ?string $url = null,
        protected array   $with = []
    )
    {
        //
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return RenderResponse
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return RenderResponse
     */
    public function setUrl(?string $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return array
     */
    public function getWith(): array
    {
        return $this->with;
    }

    /**
     * @param array $with
     * @return RenderResponse
     */
    public function setWith(array $with): static
    {
        $this->with = $with;
        return $this;
    }

    public function toResponse($request)
    {
        return Render::success($this->message, $this->url, $this->with)->response();
    }

}
