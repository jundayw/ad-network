<?php

namespace App\Services\Analysis;

use App\Models\Visitant;
use App\Models\Visits;
use Illuminate\Support\Collection;

/**
 * 记录有效点击
 */
class AnalysisRedirectService
{
    public function __construct(
        private readonly Visits $visits,
        private readonly Visitant $visitant,
    )
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

    /**
     * 访问记录是否存在
     *
     * @param Collection $request
     * @return Visits|null
     */
    private function getVisitsExists(Collection $request): ?Visits
    {
        $key = password($request->get('gu'), $request->get('uu'));
        $key = password($key, $request->get('ru'));

        if ($visits = cache($key)) {
            return $visits;
        }

        $visits = $this->visits->where([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
        ])->first();

        if (is_null($visits)) {
            return null;
        }

        $ttl = now()->endOfDay()->diffInSeconds(now());

        return cache()->remember($key, $ttl, function () use ($visits) {
            return $visits;
        });
    }

    protected function redirect(Collection $request, array $data = []): string
    {
        if (is_null($visits = $this->getVisitsExists($request))) {
            return $request->get('type');
        }

        $visitant = $this->visitant->create(array_merge([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'size_id' => $request->get('sid'),
            'publishment_id' => $request->get('pid'),
            'site_id' => $request->get('wid'),
            'channel_id' => $request->get('nid'),
            'adsense_id' => $request->get('aid'),
            'type' => $request->get('type'),
            'ip' => $request->get('ip'),
            'time' => $request->get('time'),
        ], $data));

        $visits->save([
            'visitant_id' => $visitant->getKey(),
        ]);

        return $request->get('type');
    }

    protected function element(Collection $request): string
    {
        return $this->redirect($request, [
            'advertisement_id' => $request->get('tid'),
            'program_id' => $request->get('mid'),
            'element_id' => $request->get('eid'),
            'creative_id' => $request->get('cid'),
        ]);
    }

    protected function vacant(Collection $request): string
    {
        return $this->redirect($request);
    }

    protected function material(Collection $request): string
    {
        return $this->redirect($request, [
            'material_id' => $request->get('lid'),
        ]);
    }
}
