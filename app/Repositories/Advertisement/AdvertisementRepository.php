<?php

namespace App\Repositories\Advertisement;

use App\Models\Size;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AdvertisementRepository extends Repository
{
    public function __construct(
        private readonly Size $size
    )
    {
        //
    }

    public function index(Request $request): array
    {
        $data = [];

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

        $data['size'] = [
            'xAxis' => $size->pluck('legend')->implode(','),
            'adsense' => $size->pluck('adsense_count')->implode(','),
            'creative' => $size->pluck('creative_count')->implode(','),
        ];

        $filter = [
            'time' => get_time(),
        ];

        return compact('filter', 'data');
    }
}
