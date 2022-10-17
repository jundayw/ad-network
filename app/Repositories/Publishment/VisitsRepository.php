<?php

namespace App\Repositories\Publishment;

use App\Models\Visits;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class VisitsRepository extends Repository
{
    public function __construct(
        private readonly Visits $visits
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->visits
            ->with([
                'visitor',
                'size',
            ])
            ->whereIn('type', ['EXCHANGE', 'DEFAULT', 'UNION', 'FIXED', 'HIDDEN'])
            ->where('publishment_id', $request->user()->getAttribute('publishment_id'))
            ->withWhereHas('site', function ($query) use ($request) {
                $query->when($request->get('site'), function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->get('site')}%");
                });
            })
            ->withWhereHas('channel', function ($query) use ($request) {
                $query->when($request->get('channel'), function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->get('channel')}%");
                });
            })
            ->withWhereHas('adsense', function ($query) use ($request) {
                $query->when($request->get('adsense'), function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->get('adsense')}%");
                });
            })
            ->when($request->get('guid'), function ($query) use ($request) {
                $query->where('guid', 'LIKE', "%{$request->get('guid')}%");
            })
            ->when($request->get('uuid'), function ($query) use ($request) {
                $query->where('uuid', 'LIKE', "%{$request->get('uuid')}%");
            })
            ->when($request->get('ruid'), function ($query) use ($request) {
                $query->where('ruid', 'LIKE', "%{$request->get('ruid')}%");
            })
            ->when($request->get('vacant'), function ($query) use ($request) {
                $query->where('type', $request->get('vacant'));
            })
            ->when($request->get('begin'), function ($query) use ($request) {
                $query->whereDate('request_time', '>=', $request->get('begin'));
            })
            ->when($request->get('finish'), function ($query) use ($request) {
                $query->whereDate('request_time', '<=', $request->get('finish'));
            })
            ->latest($this->visits->getKeyName());

        $data = $data->Paginate($request->get('per', $this->visits->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type = $items->getVacant($items->type);
            return $items;
        });

        $filter = [
            'vacant' => $this->visits->getVacant(),
        ];

        return compact('filter', 'data');
    }
}
