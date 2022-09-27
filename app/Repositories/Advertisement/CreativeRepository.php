<?php

namespace App\Repositories\Advertisement;

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
        private readonly Creative $creative,
        private readonly Program $program,
        private readonly Element $element,
        private readonly Size $size,
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->creative
            ->with([
                'program',
                'element',
                'size',
            ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('program'), function ($query) use ($request) {
                $query->where('program_id', $request->get('program'));
            })
            ->when($request->get('element'), function ($query) use ($request) {
                $query->where('element_id', $request->get('element'));
            })
            ->when($request->get('size'), function ($query) use ($request) {
                $query->where('size_id', $request->get('size'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->advertisement($request)
            ->oldest('state')
            ->latest($this->creative->getKeyName());

        $data = $data->Paginate($request->get('per', $this->creative->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('advertisement.creative.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('advertisement.creative.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'size' => $this->getSize(),
            'element' => $this->getProgram($request),
            'state' => $this->creative->getState(),
        ];

        return compact('filter', 'data');
    }

    private function getProgram(Request $request)
    {
        return $this->program->advertisement($request)->with([
            'element',
        ])->get();
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
            'device' => $this->size->getDevice(),
            'element' => $this->getProgram($request),
            'state' => $this->creative->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Creative
    {
        $element = $this->element->advertisement($request)->find($request->get('element'));

        if (is_null($element)) {
            throw new RenderErrorResponseException('参数无效');
        }

        $creative = $this->creative->create([
            'advertisement_id' => $request->user()->getAttribute('advertisement_id'),
            'program_id' => $element->getAttribute('program_id'),
            'element_id' => $request->get('element'),
            'size_id' => $request->get('size'),
            'title' => $request->get('title'),
            'location' => $request->get('location'),
            'image' => $request->get('image'),
            'state' => $request->get('state'),
        ]);

        if (is_null($creative)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $creative;
    }

    public function edit(Request $request): array
    {
        $data = $this->creative->advertisement($request)->find($request->get($this->creative->getKeyName()));

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
        $creative = $this->creative->advertisement($request)->find($request->get($this->creative->getKeyName()));

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
        $creative = $this->creative->advertisement($request)->find($request->get($this->creative->getKeyName()));
        if (is_null($creative)) {
            return false;
        }
        return $creative->delete();
    }
}
