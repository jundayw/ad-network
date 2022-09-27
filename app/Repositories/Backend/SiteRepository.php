<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Industry;
use App\Models\Site;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class SiteRepository extends Repository
{
    public function __construct(
        private readonly Site $site,
        private readonly Industry $industry
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->site
            ->withWhereHas('publishments', function ($query) use ($request) {
                $query->when($request->get('publishment'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('publishment')}%");
                });
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('domain'), function ($query) use ($request) {
                $query->where('domain', 'LIKE', "%{$request->get('domain')}%");
            })
            ->when($request->get('industry'), function ($query) use ($request) {
                $query->where('industry_id', $request->get('industry'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->site->getKeyName());

        $data = $data->Paginate($request->get('per', $this->site->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.site.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.site.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'industry' => $this->industry->oldest('sorting')->get(),
            'state' => $this->site->getState(),
        ];

        return compact('filter', 'data');
    }

    public function edit(Request $request): array
    {
        $data = $this->site->find($request->get($this->site->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'industry' => $this->industry->oldest('sorting')->get(),
            'state' => $this->site->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $site = $this->site->find($request->get($this->site->getKeyName()));

        if (is_null($site)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $site->update([
            'industry_id' => $request->get('industry'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->site->destroy($request->get($this->site->getKeyName())) === 0);
    }
}
