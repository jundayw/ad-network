<?php

namespace App\Repositories\Advertisement;

use App\Models\Size;
use App\Models\Vacation;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvertisementRepository extends Repository
{
    public function __construct(
        private readonly Size $size,
        private readonly Vacation $vacation
    )
    {
        //
    }

    public function index(Request $request): array
    {
        $name = sprintf('%s-%s', __METHOD__, $request->user()->advertisement_id);

        if (cache()->has($name)) {
            return cache()->get($name);
        }

        $data = [
            'size' => $this->getSize($request),
            'vacation' => $this->getVacation($request),
            'advertisement' => $request->user()->advertisement,
        ];

        $filter = [
            'time' => get_time(),
        ];

        $compact = compact('filter', 'data');

        cache()->remember($name, 5 * 60, fn() => $compact);

        return $compact;
    }

    private function getSize(Request $request): array
    {
        $size = $this->size->withCount([
            'adsense',
            'creative' => function ($query) use ($request) {
                $query->where('advertisement_id', $request->user()->getAttribute('advertisement_id'));
            },
        ])->where([
            ['pid', '<>', 0],
            ['state', '=', 'NORMAL'],
        ])->get();

        $adsenseCount  = $size->sum('adsense_count');
        $creativeCount = $size->sum('creative_count');

        $size->transform(function ($items) use ($adsenseCount, $creativeCount) {
            $items['adsense_count']  = $adsenseCount == 0 ? 0 : intval(bcdiv($items['adsense_count'], $adsenseCount, 2) * 1e2);
            $items['creative_count'] = $creativeCount == 0 ? 0 : intval(bcdiv($items['creative_count'], $creativeCount, 2) * 1e2);
            $items['legend']         = sprintf("'%sx%s'", $items['width'], $items['height']);
            return $items;
        });

        return [
            'xAxis' => $size->pluck('legend')->implode(','),
            'adsense' => $size->pluck('adsense_count')->implode(','),
            'creative' => $size->pluck('creative_count')->implode(','),
        ];
    }

    private function getVacation(Request $request): array
    {
        $times = now()->subDays(7)->daysUntil(now())->map(function (Carbon $carbon) {
            return $carbon->toDateString();
        });

        $vacation = $this->vacation
            ->selectRaw('type,SUM(origin_rate) AS rate,DATE(response_time) AS response_time')
            ->groupBy('type')
            ->groupByRaw('DATE(response_time)')
            ->whereDate('response_time', '>=', now()->subDays(7)->toDateString())
            ->where('advertisement_id', $request->user()->getAttribute('advertisement_id'))
            ->get();

        $vacations = [
            'type' => ['CPC', 'CPM', 'CPV', 'CPA', 'CPS'],
        ];

        foreach ($times as $time) {
            $vacations['times'][] = $time;
            $vacations['cpc'][]   = $vacation->where('type', 'cpc')->where('response_time', $time)->sum('rate');
            $vacations['cpm'][]   = $vacation->where('type', 'cpm')->where('response_time', $time)->sum('rate');
            $vacations['cpv'][]   = $vacation->where('type', 'cpv')->where('response_time', $time)->sum('rate');
            $vacations['cpa'][]   = $vacation->where('type', 'cpa')->where('response_time', $time)->sum('rate');
            $vacations['cps'][]   = $vacation->where('type', 'cps')->where('response_time', $time)->sum('rate');
        }

        return [
            'type' => "'" . implode("','", $vacations['type']) . "'",
            'times' => "'" . implode("','", $vacations['times']) . "'",
            'data' => [
                'CPC' => implode(',', $vacations['cpc']),
                'CPM' => implode(',', $vacations['cpm']),
                'CPV' => implode(',', $vacations['cpv']),
                'CPA' => implode(',', $vacations['cpa']),
                'CPS' => implode(',', $vacations['cps']),
            ],
        ];
    }
}
