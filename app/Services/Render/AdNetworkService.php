<?php

namespace App\Services\Render;

use Illuminate\Http\Request;

class AdNetworkService
{
    public function __construct(
        private readonly string $view,
        private readonly array $with,
        private readonly string $url,
        private readonly Request $request,
    )
    {
        //
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @return array
     */
    public function getWith(): array
    {
        return $this->with;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

}
