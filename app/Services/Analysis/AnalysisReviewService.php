<?php

namespace App\Services\Analysis;

use App\Entities\Analysis\ReviewEntity;
use App\Models\Visitor;
use App\Models\Visits;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/**
 * 记录有效展示
 */
class AnalysisReviewService
{
    public function __construct(
        private readonly Visits $visits,
        private readonly Visitor $visitor,
        private readonly ReviewEntity $entity,
    )
    {
        echo PHP_EOL;
    }

    public function __destruct()
    {
        echo PHP_EOL;
    }

    /**
     * 记录用户设备信息
     * 1.局域网内相同IP会有多个UV
     * 2.移动网络环境下相同UV会有多个IP
     *
     * @param Collection $request
     * @return Visitor
     */
    private function visitor(Collection $request): Visitor
    {
        $time    = Date::createFromTimestamp($request->get('st'))->toDateString();
        $visitor = $this->visitor->where([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ip' => $request->get('ip'),
        ])->whereDate('time', $time)->first();

        if ($visitor) {
            return $visitor;
        }

        $separator = 'x';
        $screen    = $request->get('sr') . $separator;

        [$width, $height] = explode($separator, $screen);

        return $this->visitor->create([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'language' => $request->get('nl'),
            'platform' => $request->get('np'),
            'device' => $request->get('dp'),
            'screen_width' => $width,
            'screen_height' => $height,
            'user_agent' => $request->get('ua'),
            'ip' => $request->get('ip'),
            'time' => $request->get('time'),
        ]);
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
        $visitor = $this->visitor($request);

        // 重复刷新已展示过的广告位无效
        if ($this->getVisitsExists($request)) {
            return $request->get('type');
        }

        return match ($request->get('type')) {
            'single', 'multigraph', 'popup', 'float', 'couplet' => $this->element($request, $visitor),
            'default', 'union', 'hidden' => $this->vacant($request, $visitor),
            'exchange', 'fixed' => $this->material($request, $visitor),
            default => $request->get('type')
        };
    }

    /**
     * 保存记录
     * 重复记录不保存
     *
     * @param Collection $request
     * @param Visitor $visitor
     * @param array $data
     * @return string
     */
    protected function review(Collection $request, Visitor $visitor, array $data = []): string
    {
        $this->visits->create(array_merge([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'visitor_id' => $visitor->getKey(),
            'size_id' => $request->get('sid'),
            'publishment_id' => $request->get('pid'),
            'site_id' => $request->get('wid'),
            'channel_id' => $request->get('nid'),
            'adsense_id' => $request->get('aid'),
            'document_title' => $request->get('lt'),
            'document_referrer' => $request->get('lr'),
            'document_url' => $request->get('lu'),
            'width' => $request->get('width'),
            'height' => $request->get('height'),
            'request_time' => Date::createFromTimestamp($request->get('t')),
            'response_time' => Date::createFromTimestamp($request->get('st')),
            'type' => $request->get('type'),
            'ip' => $request->get('ip'),
            'time' => $request->get('time'),
        ], $data));

        return $request->get('type');
    }

    protected function element(Collection $request, Visitor $visitor): string
    {
        return $this->review($request, $visitor, $this->entity->element($request, [
            'advertisement_id' => $request->get('tid'),
            'program_id' => $request->get('mid'),
            'element_id' => $request->get('eid'),
            'creative_id' => $request->get('cid'),
        ]));
    }

    protected function vacant(Collection $request, Visitor $visitor): string
    {
        return $this->review($request, $visitor, $this->entity->vacant($request));
    }

    protected function material(Collection $request, Visitor $visitor): string
    {
        return $this->review($request, $visitor, $this->entity->material($request, [
            'material_id' => $request->get('lid'),
        ]));
    }
}
