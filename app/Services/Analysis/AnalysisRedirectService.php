<?php

namespace App\Services\Analysis;

use Illuminate\Support\Collection;

class AnalysisRedirectService
{
    public function __construct()
    {
        echo PHP_EOL;
    }

    public function __destruct()
    {
        echo PHP_EOL;
    }

    public function run(Collection $request): string
    {
        return match ($request->get('type')) {
            'single', 'multigraph', 'popup', 'float', 'couplet' => $this->element($request),
            'default', 'union', 'hidden' => $this->vacant($request),
            'exchange', 'fixed' => $this->material($request),
            default => $request->get('type')
        };
    }

    protected function element(Collection $request): string
    {
        return $request->get('type');
    }

    protected function vacant(Collection $request): string
    {
        return $request->get('type');
    }

    protected function material(Collection $request): string
    {
        return $request->get('type');
    }
}
