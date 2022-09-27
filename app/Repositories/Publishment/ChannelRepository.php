<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Channel;
use App\Models\Site;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ChannelRepository extends Repository
{
    public function __construct(
        private readonly Channel $channel,
        private readonly Site $site,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->channel
            ->with([
                'site',
            ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('domain'), function ($query) use ($request) {
                $query->whereHas('site', function ($query) use ($request) {
                    $query->where('domain', 'LIKE', "%{$request->get('domain')}%");
                });
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->publishment($request)
            ->oldest('state')
            ->latest('site_id')
            ->latest($this->channel->getKeyName());

        $data = $data->Paginate($request->get('per', $this->channel->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('publishment.channel.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('publishment.channel.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'site' => $this->getSite($request),
            'state' => $this->channel->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getSite(Request $request)
    {
        return $this->site->publishment($request)->where('state', 'NORMAL')->get();
    }

    public function create(Request $request): array
    {
        $filter = [
            'site' => $this->getSite($request),
            'state' => $this->channel->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Channel
    {
        $channel = $this->channel->create([
            'publishment_id' => $request->user()->getAttribute('publishment_id'),
            'site_id' => $request->get('site'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'state' => $request->get('state'),
        ]);

        if (is_null($channel)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $channel;
    }

    public function edit(Request $request): array
    {
        $data = $this->channel->publishment($request)->find($request->get($this->channel->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->channel->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $channel = $this->channel->publishment($request)->find($request->get($this->channel->getKeyName()));

        if (is_null($channel)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $channel->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $channel = $this->channel->publishment($request)->withCount('adsense')->find($request->get($this->channel->getKeyName()));

        if (is_null($channel)) {
            return false;
        }

        if ($channel->adsense_count) {
            throw new RenderErrorResponseException("该频道下含有 {$channel->adsense_count} 条广告位，请先删除");
        }

        return $channel->delete();
    }
}
