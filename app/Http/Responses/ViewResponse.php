<?php

namespace App\Http\Responses;

use App\Support\Traits\NamespaceControllerActionNameTrait;
use Illuminate\Contracts\Support\Responsable;

/**
 * 视图响应
 * Class ViewResponse
 * @package App\Http\Responses
 */
class ViewResponse implements Responsable
{
    use NamespaceControllerActionNameTrait;

    public function __construct(
        protected array       $with = [],
        protected bool|string $view = true
    )
    {
        $this->view = $view === true ? $this->getNamespaceControllerActionName() : $view;
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
     * @return ViewResponse
     */
    public function setWith(array $with): static
    {
        $this->with = $with;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getView(): bool|string
    {
        return $this->view;
    }

    /**
     * @param bool|string $view
     * @return ViewResponse
     */
    public function setView(bool|string $view): static
    {
        $this->view = $view;
        return $this;
    }

    public function toResponse($request)
    {
        $view = view($this->view);

        if (is_null($this->with)) {
            return $view;
        }

        return $view->with($this->with);
    }

}
