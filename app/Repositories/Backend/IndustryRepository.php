<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Industry;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class IndustryRepository extends Repository
{
    public function __construct(
        private readonly Industry $industry
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->industry
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest('sorting')
            ->latest($this->industry->getKeyName());

        $data = $data->Paginate($request->get('per', $this->industry->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.industry.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.industry.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'state' => $this->industry->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'state' => $this->industry->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Industry
    {
        $industry = $this->industry->create([
            'title' => $request->get('title'),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);

        if (is_null($industry)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $industry;
    }

    public function edit(Request $request): array
    {
        $data = $this->industry->find($request->get($this->industry->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->industry->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $industry = $this->industry->find($request->get($this->industry->getKeyName()));

        if (is_null($industry)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $industry->update([
            'title' => $request->get('title'),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->industry->destroy($request->get($this->industry->getKeyName())) === 0);
    }
}
