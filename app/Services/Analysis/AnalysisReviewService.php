<?php

namespace App\Services\Analysis;

use App\Models\Adsense;
use App\Models\Visitor;
use App\Models\Visits;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

class AnalysisReviewService
{
    public function __construct(
        private readonly Visits $visits,
        private readonly Visitor $visitor,
        private readonly Adsense $adsense,
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
     *
     * @param Collection $request
     * @return Visitor
     */
    private function visitor(Collection $request): Visitor
    {
        $key = password($request->get('gu', generate_string()), $request->get('uu', generate_string()));
        $ttl = now()->endOfDay()->diffInSeconds(now());
        return cache()->remember($key, $ttl, function () use ($request) {
            $visitor = $this->visitor->where([
                'guid' => $request->get('gu'),
                'uuid' => $request->get('uu'),
            ])->whereDate('create_time', get_time('Y-m-d'))->first();

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
            ]);
        });
    }

    public function run(Collection $request): string
    {
        $visitor = $this->visitor($request);

        return match ($request->get('type')) {
            'single', 'multigraph', 'popup', 'float', 'couplet' => $this->element($request, $visitor),
            'default', 'union', 'hidden' => $this->vacant($request, $visitor),
            'exchange', 'fixed' => $this->material($request, $visitor),
            default => $request->get('type')
        };
    }

    /**
     * 判断用户是新访客/老访客
     *
     * @param Collection $request
     * @return string
     */
    private function getVisitsState(Collection $request): string
    {
        $key = password($request->get('gu'), 'guid');

        if ($visits = cache($key)) {
            return $visits;
        }

        if ($this->visits->where('guid', $request->get('gu'))->count() == 0) {
            return 'NORMAL';
        }

        return cache()->rememberForever($key, function () {
            return 'DISABLE';
        });
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
        if ($this->getVisitsExists($request)) {
            return $request->get('type');
        }

        $adsense = $this->adsense->find($request->get('aid'));

        $this->visits->create(array_merge([
            'guid' => $request->get('gu'),
            'uuid' => $request->get('uu'),
            'ruid' => $request->get('ru'),
            'visitor_id' => $visitor->getKey(),
            'size_id' => $request->get('sid'),
            // 'advertisement_id' => $request->get('tid', 0),
            // 'program_id' => $request->get('mid', 0),
            // 'element_id' => $request->get('eid', 0),
            // 'creative_id' => $request->get('cid', 0),
            'publishment_id' => $request->get('pid'),
            'site_id' => $adsense->site_id,
            'channel_id' => $adsense->channel_id,
            'adsense_id' => $request->get('aid'),
            // 'material_id' => $request->get('lid', 0),
            'document_title' => $request->get('lt'),
            'document_referrer' => $request->get('lr'),
            'document_url' => $request->get('lu'),
            'width' => $request->get('width'),
            'height' => $request->get('height'),
            'request_time' => Date::createFromTimestamp($request->get('t')),
            'response_time' => Date::createFromTimestamp($request->get('st')),
            'origin' => $adsense->origin,
            'device' => $adsense->device,
            'type' => $request->get('type'),
            'charging' => $adsense->charging,
            'ip' => $request->get('ip'),
            'state' => $this->getVisitsState($request),
        ], $data));

        return $request->get('type');
    }

    protected function element(Collection $request, Visitor $visitor): string
    {
        return $this->review($request, $visitor, [
            'advertisement_id' => $request->get('tid'),
            'program_id' => $request->get('mid'),
            'element_id' => $request->get('eid'),
            'creative_id' => $request->get('cid'),
        ]);
    }

    protected function vacant(Collection $request, Visitor $visitor): string
    {
        return $this->review($request, $visitor, $request->get('lid') ? [
            'material_id' => $request->get('lid'),
        ] : []);
    }

    protected function material(Collection $request, Visitor $visitor): string
    {
        return $this->review($request, $visitor, [
            'material_id' => $request->get('lid'),
        ]);
    }
}
