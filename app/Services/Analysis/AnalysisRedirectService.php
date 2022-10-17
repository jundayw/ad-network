<?php

namespace App\Services\Analysis;

use App\Entities\Analysis\RedirectEntity;
use App\Models\Visitant;
use App\Models\Visits;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/**
 * 记录有效点击
 */
class AnalysisRedirectService
{
    public function __construct(
        private readonly Visits $visits,
        private readonly Visitant $visitant,
        private readonly RedirectEntity $entity,
    )
    {
        echo PHP_EOL;
    }

    public function __destruct()
    {
        echo PHP_EOL;
    }

    /**
     * 访问记录是否存在
     *
     * @param Collection $request
     * @return Visits|null
     */
    private function getVisitsExists(Collection $request): ?Visits
    {
        return $this->visits->where([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'creative_id' => $request->get('cid', 0),// 多图兼容
        ])->first();
    }

    public function run(Collection $request): string
    {
        // 未展示过的广告位点击行为无效
        if (is_null($visits = $this->getVisitsExists($request))) {
            return $request->get('type');
        }

        $count = $this->visitant->where([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'creative_id' => $request->get('cid', 0),
        ])->count();

        // 重复点击已点击过的广告链接行为无效
        if ($count) {
            return $request->get('type');
        }

        return match ($request->get('type')) {
            'single', 'multigraph', 'popup', 'float', 'couplet' => $this->element($request, $visits),
            'default', 'union', 'hidden' => $this->vacant($request, $visits),
            'exchange', 'fixed' => $this->material($request, $visits),
            default => $request->get('type')
        };
    }

    protected function redirect(Collection $request, Visits $visits, array $data = []): string
    {
        $visitant = $this->visitant->create(array_merge([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'visits_id' => $visits->getKey(),
            'size_id' => $request->get('sid'),
            'publishment_id' => $request->get('pid'),
            'site_id' => $request->get('wid'),
            'channel_id' => $request->get('nid'),
            'adsense_id' => $request->get('aid'),
            'request_time' => Date::createFromTimestamp($request->get('t')),
            'response_time' => Date::createFromTimestamp($request->get('st')),
            'type' => $request->get('type'),
            'ip' => $request->get('ip'),
            'time' => $request->get('time'),
        ], $data));

        if ($vacation_id = $visitant->getAttribute('vacation_id')) {
            $visits->setAttribute('vacation_id', $vacation_id);
        }

        $visits->update([
            'visitant_id' => $visitant->getKey(),
        ]);

        return $request->get('type');
    }

    protected function element(Collection $request, Visits $visits): string
    {
        return $this->redirect($request, $visits, $this->entity->element($request, [
            'advertisement_id' => $request->get('tid'),
            'program_id' => $request->get('mid'),
            'element_id' => $request->get('eid'),
            'creative_id' => $request->get('cid'),
        ]));
    }

    protected function vacant(Collection $request, Visits $visits): string
    {
        return $this->redirect($request, $visits, $this->entity->vacant($request));
    }

    protected function material(Collection $request, Visits $visits): string
    {
        return $this->redirect($request, $visits, $this->entity->material($request, [
            'material_id' => $request->get('lid'),
        ]));
    }
}
