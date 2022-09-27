<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Material;
use App\Models\Size;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class MaterialRepository extends Repository
{
    public function __construct(
        private readonly Material $material,
        private readonly Size $size
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->material
            ->with([
                'size',
            ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('size'), function ($query) use ($request) {
                $query->where('size_id', $request->get('size'));
            })
            ->when($request->get('device'), function ($query) use ($request) {
                $query->where('device', $request->get('device'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->publishment($request)
            ->oldest('state')
            ->latest($this->material->getKeyName());

        $data = $data->Paginate($request->get('per', $this->material->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->device  = $items->getDevice($items->device);
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('publishment.material.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('publishment.material.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'size' => $this->getSize(),
            'device' => $this->material->getDevice(),
            'state' => $this->material->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getSize()
    {
        return $this->size->with([
            'size' => function ($query) {
                $query->where([
                    'state' => 'NORMAL',
                ])->oldest('sorting')->oldest('id');
            },
        ])->where([
            'pid' => 0,
            'state' => 'NORMAL',
        ])->oldest('sorting')->oldest('id')->get();
    }

    public function create(Request $request): array
    {
        $filter = [
            'size' => $this->getSize()->pluck('size')->flatten()->groupBy('device'),
            'device' => $this->material->getDevice(),
            'state' => $this->material->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Material
    {
        $material = $this->material->create([
            'publishment_id' => $request->user()->getAttribute('publishment_id'),
            'size_id' => $request->get('size'),
            'title' => $request->get('title'),
            'device' => $request->get('device'),
            'location' => $request->get('location'),
            'image' => $request->get('image'),
            'state' => $request->get('state'),
        ]);

        if (is_null($material)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $material;
    }

    public function edit(Request $request): array
    {
        $data = $this->material->with([
            'size',
        ])->publishment($request)->find($request->get($this->material->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'device' => $this->material->getDevice(),
            'state' => $this->material->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $material = $this->material->publishment($request)->find($request->get($this->material->getKeyName()));

        if (is_null($material)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $material->update([
            'title' => $request->get('title'),
            'location' => $request->get('location'),
            'image' => $request->get('image'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $material = $this->material->publishment($request)->find($request->get($this->material->getKeyName()));
        if (is_null($material)) {
            return false;
        }
        return $material->delete();
    }
}
