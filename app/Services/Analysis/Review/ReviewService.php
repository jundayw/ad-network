<?php

namespace App\Services\Analysis\Review;

use App\Models\Advertisement;
use App\Models\Element;
use App\Models\Material;
use App\Models\Publishment;
use App\Models\System;
use App\Models\Vacation;
use App\Models\Visits;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function __construct(
        private readonly Visits $visits,
        private readonly Vacation $vacation,
        private readonly Advertisement $advertisement,
        private readonly Element $element,
        private readonly Publishment $publishment,
        private readonly Material $material,
        private readonly System $system,
    )
    {
        //
    }

    private function elementCPM(Collection $request, Element $element): ?Vacation
    {
        $vacation = $this->vacation->where([
            'creative_id' => $request->get('cid'),
            'site_id' => $request->get('wid'),
            'ip' => $request->get('ip'),
        ])->whereDate('request_time', Date::createFromTimestamp($request->get('st'))->toDateString())->count();

        if ($vacation) {
            return null;
        }

        return $this->element($request, $element);
    }

    private function elementCPV(Collection $request, Element $element): ?Vacation
    {
        $vacation = $this->vacation->where([
            'uuid' => $request->get('uu'),
            'creative_id' => $request->get('cid'),
            'site_id' => $request->get('wid'),
            ['request_time', '>', Date::createFromTimestamp($request->get('st'))->subSeconds(config('system.cpv_min_time', 300))],
        ])->count();

        if ($vacation) {
            return null;
        }

        return $this->element($request, $element);
    }

    protected function element(Collection $request, Element $element): ?Vacation
    {
        DB::beginTransaction();

        try {
            $rateOriginal  = bcdiv($element->getRawOriginal('rate', 0), 1000, 4);
            $rateAttribute = bcdiv($element->getAttribute('rate', 0), 1000, 4);

            $pt     = $rateOriginal * bcdiv(config('system.rate'), 100, 4);
            $origin = max($rateOriginal - $pt, 0);
            $this->system->where('key', 'TOTAL_AMOUNT')->increment('value', bcdiv($rateOriginal - $origin, 10000, 4));

            // 广告主支付费用
            $this->advertisement->find($request->get('tid'))->decrement('balance', $rateOriginal);
            // 流量主获取佣金
            $this->publishment->find($request->get('pid'))->increment('balance', $origin);
            // 广告计划限额更新
            if ($element->program->getAttribute('expire') == ($expire = get_time('Y-m-d'))) {
                $element->program->increment('charge', $rateOriginal);
            } else {
                $element->program->lockForUpdate()->find($element->program->id)->update([
                    'charge' => $rateAttribute,
                    'expire' => $expire,
                ]);
            }

            // 新增流水
            $vacation = $this->vacation->create([
                'guid' => $request->get('gu'),
                'uuid' => $request->get('uu'),
                'ruid' => $request->get('ru'),
                'size_id' => $request->get('sid'),
                'advertisement_id' => $request->get('tid'),
                'program_id' => $request->get('mid'),
                'element_id' => $request->get('eid'),
                'creative_id' => $request->get('cid'),
                'publishment_id' => $request->get('pid'),
                'site_id' => $request->get('wid'),
                'channel_id' => $request->get('nid'),
                'adsense_id' => $request->get('aid'),
                'request_time' => Date::createFromTimestamp($request->get('t')),
                'response_time' => Date::createFromTimestamp($request->get('st')),
                'type' => $element->getAttribute('type'),
                'rate' => bcdiv($origin, 10000, 4),
                'ip' => $request->get('ip'),
                'time' => $request->get('time'),
            ]);

            DB::commit();

            return $vacation;
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return null;
    }

    protected function vacantExchange(Collection $request)
    {
        $visits = $this->visits->where([
            'uuid' => $request->get('uu'),
            'material_id' => $request->get('lid'),
            'site_id' => $request->get('wid'),
        ])->whereDate('request_time', Date::createFromTimestamp($request->get('st'))->toDateString())->count();

        if ($visits) {
            return null;
        }

        $material = $this->material->with([
            'publishments',
        ])->find($request->get('lid'));

        if (is_null($material)) {
            return null;
        }

        $material->publishments->decrement('weight');

        $this->publishment->find($request->get('pid'))->increment('weight');

        return null;
    }

    public function review(Collection $request): ?Vacation
    {
        if ($request->get('type') == 'exchange') {
            return $this->vacantExchange($request);
        }

        $element = $this->element->with([
            'program',
        ])->find($request->get('eid'));

        if (is_null($element)) {
            return null;
        }

        if ($element->getAttribute('type') == 'cpm') {
            return $this->elementCPM($request, $element);
        }

        if ($element->getAttribute('type') == 'cpv') {
            return $this->elementCPV($request, $element);
        }

        return null;
    }
}
