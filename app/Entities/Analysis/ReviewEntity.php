<?php

namespace App\Entities\Analysis;

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

class ReviewEntity extends Entity
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
        $time     = Date::createFromTimestamp($request->get('st'))->toDateString();
        $vacation = $this->vacation->where([
            'creative_id' => $request->get('cid'),
            'site_id' => $request->get('wid'),
            'ip' => $request->get('ip'),
        ])->whereDate('request_time', $time)->count();

        if ($vacation) {
            return null;
        }

        return $this->elementVacation($request, $element);
    }

    private function elementCPV(Collection $request, Element $element): ?Vacation
    {
        $time     = Date::createFromTimestamp($request->get('st'))->subSeconds(config('system.cpv_min_time', 300));
        $vacation = $this->vacation->where([
            'creative_id' => $request->get('cid'),
            'site_id' => $request->get('wid'),
            'uuid' => $request->get('uu'),
        ])->where('request_time', '>', $time)->count();

        if ($vacation) {
            return null;
        }

        return $this->elementVacation($request, $element);
    }

    protected function elementVacation(Collection $request, Element $element): ?Vacation
    {
        DB::beginTransaction();

        try {
            $rateOriginal  = bcdiv($element->getRawOriginal('rate', 0), 1000, 4);
            $rateAttribute = bcdiv($element->getAttribute('rate'), 1000, 4);

            $pt     = $rateOriginal * bcdiv(config('system.rate'), 100, 4);
            $origin = max($rateOriginal - $pt, 0);
            $this->system->where('key', 'TOTAL_AMOUNT')->increment('value', bcdiv($rateOriginal - $origin, 10000, 4));

            // 广告主支付费用
            $this->advertisement->find($request->get('tid'))->decrement('balance', $rateOriginal);
            // 流量主获取佣金
            $this->publishment->find($request->get('pid'))->increment('balance', $origin);
            // 广告计划限额更新
            $expire = Date::createFromTimestamp($request->get('st'))->toDateString();
            if ($element->program->getAttribute('expire') == $expire) {
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
                'origin_rate' => $rateAttribute,
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

    public function element(Collection $request, array $data = []): array
    {
        $element = $this->element->withWhereHas('program')->find($request->get('eid'));

        if (is_null($element)) {
            return $data;
        }

        $vacation = match ($element->getAttribute('type')) {
            'cpm' => $this->elementCPM($request, $element),
            'cpv' => $this->elementCPV($request, $element),
            default => null
        };

        if (is_null($vacation)) {
            return $data;
        }

        return array_merge($data, [
            'vacation_id' => $vacation->getKey(),
        ]);
    }

    public function vacant(Collection $request, array $data = []): array
    {
        return $data;
    }

    private function materialExchange(Collection $request): ?Material
    {
        $time   = Date::createFromTimestamp($request->get('st'))->toDateString();
        $visits = $this->visits->where([
            'material_id' => $request->get('lid'),
            'site_id' => $request->get('wid'),
            'uuid' => $request->get('uu'),
        ])->whereDate('request_time', $time)->count();

        if ($visits) {
            return null;
        }

        $material = $this->material->withWhereHas('publishments')->find($request->get('lid'));

        if (is_null($material)) {
            return null;
        }

        $material->publishments->decrement('weight');

        $this->publishment->lockForUpdate()->find($request->get('pid'))->increment('weight');

        return $material;
    }

    public function material(Collection $request, array $data = []): array
    {
        $material = match ($request->get('type')) {
            'exchange' => $this->materialExchange($request),
            default => null
        };

        if (is_null($material)) {
            return $data;
        }

        return $data;
    }
}
