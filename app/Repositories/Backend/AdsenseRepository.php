<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Adsense;
use App\Models\Size;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AdsenseRepository extends Repository
{
    public function __construct(
        private readonly Adsense $adsense,
        private readonly Size $size,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->adsense
            ->withWhereHas('publishments', function ($query) use ($request) {
                $query->when($request->get('publishment'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('publishment')}%");
                });
            })
            ->whereHas('site', function ($query) use ($request) {
                $query->when($request->get('domain'), function ($query) use ($request) {
                    $query->where('domain', 'LIKE', "%{$request->get('domain')}%");
                });
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('size'), function ($query) use ($request) {
                $query->where('size_id', $request->get('size'));
            })
            ->when($request->get('origin'), function ($query) use ($request) {
                $query->where('origin', $request->get('origin'));
            })
            ->when($request->get('device'), function ($query) use ($request) {
                $query->where('device', $request->get('device'));
            })
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->when($request->get('charging'), function ($query) use ($request) {
                $query->where('charging', $request->get('charging'));
            })
            ->when($request->get('vacant'), function ($query) use ($request) {
                $query->where('vacant', $request->get('vacant'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->adsense->getKeyName());

        $data = $data->Paginate($request->get('per', $this->adsense->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->origin   = $items->getOrigin($items->origin);
            $items->device   = $items->getDevice($items->device);
            $items->type     = $items->getType($items->type);
            $items->charging = $items->getCharging($items->charging);
            $items->vacant   = $items->getVacant($items->vacant);
            $items->state    = $items->getState($items->state);
            $items->edit     = route('backend.adsense.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy  = route('backend.adsense.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'size' => $this->getSize(),
            'origin' => $this->adsense->getOrigin(),
            'device' => $this->adsense->getDevice(),
            'type' => $this->adsense->getType(),
            'charging' => $this->adsense->getCharging(),
            'vacant' => $this->adsense->getVacant(),
            'state' => $this->adsense->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getSize()
    {
        return $this->size->with([
            'size' => function ($query) {
                $query->where([
                    'state' => 'NORMAL',
                ])->oldest('state')->oldest('sorting')->oldest('id');
            },
        ])->where([
            'pid' => 0,
            'state' => 'NORMAL',
        ])->oldest('state')->oldest('sorting')->oldest('id')->get();
    }

    public function edit(Request $request): array
    {
        $data = $this->adsense->find($request->get($this->adsense->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->adsense->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $adsense = $this->adsense->find($request->get($this->adsense->getKeyName()));

        if (is_null($adsense)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $adsense->update([
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->adsense->destroy($request->get($this->adsense->getKeyName())) === 0);
    }
}
