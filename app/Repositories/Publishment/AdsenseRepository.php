<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Adsense;
use App\Models\Channel;
use App\Models\Site;
use App\Models\Size;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class AdsenseRepository extends Repository
{
    public function __construct(
        private readonly Adsense $adsense,
        private readonly Site $site,
        private readonly Size $size,
        private readonly Channel $channel,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->adsense
            ->with([
                'site',
                'channel',
                'size',
            ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('site'), function ($query) use ($request) {
                $query->where('site_id', $request->get('site'));
            })
            ->when($request->get('channel'), function ($query) use ($request) {
                $query->where('channel_id', $request->get('channel'));
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
            ->when($request->get('vacant'), function ($query) use ($request) {
                $query->where('vacant', $request->get('vacant'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->publishment($request)
            ->oldest('state')
            ->latest($this->adsense->getKeyName());

        $data = $data->Paginate($request->get('per', $this->adsense->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->origin  = $items->getOrigin($items->origin);
            $items->device  = $items->getDevice($items->device);
            $items->type    = $items->getType($items->type);
            $items->vacant  = $items->getVacant($items->vacant);
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('publishment.adsense.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('publishment.adsense.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'site' => $this->getSite($request),
            'size' => $this->getSize(),
            'origin' => $this->adsense->getOrigin(),
            'device' => $this->adsense->getDevice(),
            'type' => $this->adsense->getType(),
            'vacant' => $this->adsense->getVacant(),
            'state' => $this->adsense->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getSite(Request $request)
    {
        return $this->site->with([
            'channel' => function ($query) {
                $query->latest('id');
            },
        ])->publishment($request)->where([
            'state' => 'NORMAL',
        ])->latest('id')->get();
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

    public function create(Request $request): array
    {
        $filter = [
            'site' => $this->getSite($request),
            'size' => $this->getSize(),
            'origin' => $this->adsense->getOrigin(),
            'device' => $this->adsense->getDevice(),
            'type' => $this->adsense->getType(),
            'vacant' => $this->adsense->getVacant(),
            'state' => $this->adsense->getState(),
        ];
        return compact('filter');
    }

    public function store(Request $request): Adsense
    {
        $channel = $this->channel->with([
            'site',
        ])->publishment($request)->where([
            'id' => $request->get('channel'),
            'state' => 'NORMAL',
        ])->first();

        if (is_null($channel)) {
            throw new RenderErrorResponseException('频道无效');
        }

        $adsense = [
            'publishment_id' => $channel->getAttribute('publishment_id'),
            'industry_id' => $channel->site->getAttribute('industry_id'),
            'site_id' => $channel->site->getAttribute('id'),
            'channel_id' => $channel->getAttribute('id'),
            'size_id' => $request->get('size'),
            'title' => $request->get('title'),
            'origin' => $request->get('origin'),
            'device' => $request->get('device'),
            'type' => $request->get('type'),
            'vacant' => $request->get('vacant'),
            'state' => $request->get('state'),
        ];

        if ($request->get('vacant') == 'default') {
            $adsense['locator'] = $request->get('locator');
            $adsense['image']   = $request->get('image');
        }

        if ($request->get('vacant') == 'union') {
            $adsense['code'] = $request->get('code');
        }

        $adsense = $this->adsense->create($adsense);

        if (is_null($adsense)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $adsense;
    }

    public function edit(Request $request): array
    {
        $data = $this->adsense->with([
            'channel',
            'size',
        ])->publishment($request)->find($request->get($this->adsense->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'origin' => $this->adsense->getOrigin(),
            'device' => $this->adsense->getDevice(),
            'type' => $this->adsense->getType(),
            'vacant' => $this->adsense->getVacant(),
            'state' => $this->adsense->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $adsense = $this->adsense->publishment($request)->find($request->get($this->adsense->getKeyName()));

        if (is_null($adsense)) {
            throw new RenderErrorResponseException('参数有误');
        }

        $data = [
            'title' => $request->get('title'),
            'origin' => $request->get('origin'),
            'device' => $request->get('device'),
            'type' => $request->get('type'),
            'vacant' => $request->get('vacant'),
            'state' => $request->get('state'),
        ];

        if ($request->get('vacant') == 'default') {
            $data['locator'] = $request->get('locator');
            $data['image']   = $request->get('image');
        }

        if ($request->get('vacant') == 'union') {
            $data['code'] = $request->get('code');
        }

        return $adsense->update($data);
    }

    public function destroy(Request $request): bool
    {
        return !($this->adsense->publishment($request)->destroy($request->get($this->adsense->getKeyName())) === 0);
    }
}
