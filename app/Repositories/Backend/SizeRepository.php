<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Size;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class SizeRepository extends Repository
{
    public function __construct(
        private readonly Size $size
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->size
            ->with([
                'size' => function ($query) use ($request) {
                    $query->when($request->get('title'), function ($query) use ($request) {
                        $query->where('title', 'LIKE', "%{$request->get('title')}%");
                    })->when($request->get('type'), function ($query) use ($request) {
                        $query->where('type', 'LIKE', "%{$request->get('type')}%");
                    })->when($request->get('device'), function ($query) use ($request) {
                        $query->where('device', 'LIKE', "%{$request->get('device')}%");
                    })->when($request->get('state'), function ($query) use ($request) {
                        $query->where('state', $request->get('state'));
                    });
                },
            ])
            ->where('pid', 0)
            ->oldest('state')
            ->oldest('sorting')
            ->oldest($this->size->getKeyName());

        $data = $data->get();

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.size.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.size.destroy', [$items->getKeyName() => $items->getKey()]);
            $items->size->transform(function ($items) {
                $items->devices = collect($items->device)->map(function ($device) use ($items) {
                    return $items->getDevice($device);
                })->implode('、');
                $items->types   = collect($items->type)->map(function ($type) use ($items) {
                    return $items->getType($type);
                })->implode('、');
                $items->state   = $items->getState($items->state);
                $items->edit    = route('backend.size.edit', [$items->getKeyName() => $items->getKey()]);
                $items->destroy = route('backend.size.destroy', [$items->getKeyName() => $items->getKey()]);
                return $items;
            });
            return $items;
        });

        $filter = [
            'device' => $this->size->getDevice(),
            'type' => $this->size->getType(),
            'state' => $this->size->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getSite()
    {
        return $this->size->where('pid', 0)->oldest('sorting')->get();
    }

    public function create(Request $request): array
    {
        $filter = [
            'size' => $this->getSite(),
            'device' => $this->size->getDevice(),
            'type' => $this->size->getType(),
            'state' => $this->size->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Size
    {
        $size = $this->size->create([
            'pid' => $request->get('pid'),
            'title' => $request->get('title'),
            'width' => $request->get('width'),
            'height' => $request->get('height'),
            'description' => $request->get('description'),
            'device' => $request->get('device', []),
            'type' => $request->get('type', []),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);

        if (is_null($size)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $size;
    }

    public function edit(Request $request): array
    {
        $data = $this->size->find($request->get($this->size->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'size' => $this->getSite(),
            'device' => $this->size->getDevice(),
            'type' => $this->size->getType(),
            'state' => $this->size->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $size = $this->size->find($request->get($this->size->getKeyName()));

        if (is_null($size)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $size->update([
            'title' => $request->get('title'),
            'width' => $request->get('width'),
            'height' => $request->get('height'),
            'description' => $request->get('description'),
            'device' => $request->get('device', []),
            'type' => $request->get('type', []),
            'sorting' => $request->get('sorting'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $size = $this->size->where('pid', $request->get($this->size->getKeyName()))->first();

        if (!is_null($size)) {
            throw new RenderErrorResponseException('当前记录下含有其他记录，请先删除');
        }

        return !($this->size->destroy($request->get($this->size->getKeyName())) === 0);
    }
}
