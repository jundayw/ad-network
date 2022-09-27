<?php

namespace App\Repositories\Backend;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Element;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ElementRepository extends Repository
{
    public function __construct(
        private readonly Element $element
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->element
            ->withWhereHas('advertisements', function ($query) use ($request) {
                $query->when($request->get('advertisement'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('advertisement')}%");
                });
            })
            ->withWhereHas('program', function ($query) use ($request) {
                $query->when($request->get('program'), function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%{$request->get('program')}%");
                });
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('release_begin'), function ($query) use ($request) {
                $query->where('release_begin', '>=', $request->get('release_begin'));
            })
            ->when($request->get('release_finish'), function ($query) use ($request) {
                $query->where('release_finish', '<=', $request->get('release_finish'));
            })
            ->when($request->get('period_begin'), function ($query) use ($request) {
                $query->where('period_begin', '>=', $request->get('period_begin'));
            })
            ->when($request->get('period_finish'), function ($query) use ($request) {
                $query->where('period_finish', '<=', $request->get('period_finish'));
            })
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->element->getKeyName());

        $data = $data->Paginate($request->get('per', $this->element->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type    = $items->getType($items->type);
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.element.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.element.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'type' => $this->element->getType(),
            'state' => $this->element->getState(),
        ];

        return compact('filter', 'data');
    }

    public function edit(Request $request): array
    {
        $data = $this->element->find($request->get($this->element->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->element->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $element = $this->element->find($request->get($this->element->getKeyName()));

        if (is_null($element)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $element->update([
            'title' => $request->get('title'),
            'release_begin' => $request->get('release_begin'),
            'release_finish' => $request->get('release_finish'),
            'period_begin' => $request->get('period_begin'),
            'period_finish' => $request->get('period_finish'),
            'rate' => $request->get('rate'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->element->destroy($request->get($this->element->getKeyName())) === 0);
    }
}
