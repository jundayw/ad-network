<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Element;
use App\Models\Program;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElementRepository extends Repository
{
    public function __construct(
        private readonly Element $element,
        private readonly Program $program
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->element
            ->with([
                'program',
            ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('program'), function ($query) use ($request) {
                $query->where('program_id', $request->get('program'));
            })
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type', $request->get('type'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
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
            ->advertisement($request)
            ->oldest('state')
            ->latest($this->element->getKeyName());

        $data = $data->Paginate($request->get('per', $this->element->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->type    = $items->getType($items->type);
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('advertisement.element.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('advertisement.element.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'program' => $this->program($request),
            'type' => $this->element->getType(),
            'state' => $this->element->getState(),
        ];

        return compact('filter', 'data');
    }

    private function program(Request $request)
    {
        return $this->program->advertisement($request)->get();
    }

    public function create(Request $request): array
    {
        $filter = [
            'program' => $this->program($request),
            'type' => $this->element->getType(),
            'state' => $this->element->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Element
    {
        $element = $this->element->create([
            'advertisement_id' => $request->user()->getAttribute('advertisement_id'),
            'program_id' => $request->get('program'),
            'title' => $request->get('title'),
            'release_begin' => $request->get('release_begin'),
            'release_finish' => $request->get('release_finish'),
            'period_begin' => $request->get('period_begin'),
            'period_finish' => $request->get('period_finish'),
            'type' => $request->get('type'),
            'rate' => $request->get('rate'),
            'state' => $request->get('state'),
        ]);

        if (is_null($element)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $element;
    }

    public function edit(Request $request): array
    {
        $data = $this->element->advertisement($request)->with([
            'program',
        ])->find($request->get($this->element->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'type' => $this->element->getType(),
            'state' => $this->element->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $element = $this->element->advertisement($request)->find($request->get($this->element->getKeyName()));

        if (is_null($element)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $element->update([
            'title' => $request->get('title'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $element = $this->element->advertisement($request)->withCount('creative')->find($request->get($this->element->getKeyName()));

        if (is_null($element)) {
            return false;
        }

        if ($element->creative_count) {
            throw new RenderErrorResponseException("该广告单元下含有 {$element->creative_count} 条广告创意，请先删除");
        }

        return $element->delete();
    }
}
