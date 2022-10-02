<?php

namespace App\Services\Analysis;

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
        return $this->visits->where([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'creative_id' => $request->get('cid', 0),// 多图兼容
        ])->first();
    }

    protected function redirect(Collection $request, array $data = []): string
    {
        $request = $request->merge($data);

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

        $visitant = $this->visitant->create(array_merge([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
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

        $visits->update([
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
