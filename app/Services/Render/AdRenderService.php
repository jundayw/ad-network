<?php

namespace App\Services\Render;

class AdRenderService
{
    public function __construct(
        private readonly string $view = '',
        private readonly array $with = []
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
}
