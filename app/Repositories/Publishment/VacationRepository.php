<?php

namespace App\Repositories\Publishment;

use App\Models\Vacation;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class VacationRepository extends Repository
{
    public function __construct(
        private readonly Vacation $vacation
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->vacation
            ->with([
                'visits.visitor',
                'size',
            ])
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
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->when($request->get('begin'), function ($query) use ($request) {
                $query->whereDate('request_time', '>=', $request->get('begin'));
            })
            ->when($request->get('finish'), function ($query) use ($request) {
                $query->whereDate('request_time', '<=', $request->get('finish'));
            })
            ->latest($this->vacation->getKeyName());

        $data = $data->Paginate($request->get('per', $this->vacation->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $filter = [
            'type' => $this->vacation->getType(),
        ];

        return compact('filter', 'data');
    }
}
