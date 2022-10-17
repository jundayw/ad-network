<?php

namespace App\Repositories\Backend;

use App\Models\Vacation;
use App\Models\Visitant;
use App\Models\Visits;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ReportRepository extends Repository
{
    public function __construct(
        private readonly Visits $visits,
        private readonly Visitant $visitant,
        private readonly Vacation $vacation
    )
    {
        //
    }

    public function visits(Request $request): array
    {
        $data = $this->visits
            ->with([
                'visitor',
                'size',
                'program',
                'element',
                'creative',
            ])
            ->when($request->get('program'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('program')}%");
            })
            ->when($request->get('element'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('element')}%");
            })
            ->when($request->get('creative'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('creative')}%");
            })
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
            ->latest($this->visits->getKeyName());

        $data = $data->Paginate($request->get('per', $this->visits->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type = $items->getType($items->type);
            return $items;
        });

        $filter = [
            'type' => $this->visits->getType(),
        ];

        return compact('filter', 'data');
    }

    public function visitant(Request $request): array
    {
        $data = $this->visitant
            ->with([
                'visits.visitor',
                'size',
                'program',
                'element',
                'creative',
            ])
            ->when($request->get('program'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('program')}%");
            })
            ->when($request->get('element'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('element')}%");
            })
            ->when($request->get('creative'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('creative')}%");
            })
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
            ->latest($this->visits->getKeyName());

        $data = $data->Paginate($request->get('per', $this->visits->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type = $items->getType($items->type);
            return $items;
        });

        $filter = [
            'type' => $this->visitant->getType(),
        ];

        return compact('filter', 'data');
    }

    public function vacation(Request $request): array
    {
        $data = $this->vacation
            ->with([
                'visits.visitor',
                'size',
                'program',
                'element',
                'creative',
            ])
            ->when($request->get('program'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('program')}%");
            })
            ->when($request->get('element'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('element')}%");
            })
            ->when($request->get('creative'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('creative')}%");
            })
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
            ->latest($this->visits->getKeyName());

        $data = $data->Paginate($request->get('per', $this->visits->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type = $items->getType($items->type);
            return $items;
        });

        $filter = [
            'type' => $this->vacation->getType(),
        ];

        return compact('filter', 'data');
    }
}
