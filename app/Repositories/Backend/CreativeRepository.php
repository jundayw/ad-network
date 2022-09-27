<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Creative;
use App\Models\Element;
use App\Models\Program;
use App\Models\Size;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class CreativeRepository extends Repository
{
    public function __construct(
        private readonly Program $program,
        private readonly Element $element,
        private readonly Creative $creative,
        private readonly Size $size
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->creative
            ->withWhereHas('advertisements', function ($query) use ($request) {
                $query->when($request->get('advertisement'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('advertisement')}%");
                });
            })
            ->withWhereHas('program', function ($query) use ($request) {
                $query->when($request->get('program'), function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->get('program')}%");
                })->when($request->get('device'), function ($query) use ($request) {
                    $query->where('device', $request->get('device'));
                });
            })
            ->withWhereHas('element', function ($query) use ($request) {
                $query->when($request->get('element'), function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->get('element')}%");
                })->when($request->get('type'), function ($query) use ($request) {
                    $query->where('type', $request->get('type'));
                });
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('size'), function ($query) use ($request) {
                $query->where('size_id', $request->get('size'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->creative->getKeyName());

        $data = $data->Paginate($request->get('per', $this->creative->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.creative.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.creative.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'size' => $this->getSize(),
            'device' => $this->program->getDevice(),
            'type' => $this->element->getType(),
            'state' => $this->creative->getState(),
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

    public function edit(Request $request): array
    {
        $data = $this->creative->find($request->get($this->creative->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->creative->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $creative = $this->creative->find($request->get($this->creative->getKeyName()));

        if (is_null($creative)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $creative->update([
            'title' => $request->get('title'),
            'location' => $request->get('location'),
            'image' => $request->get('image'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->creative->destroy($request->get($this->creative->getKeyName())) === 0);
    }
}
