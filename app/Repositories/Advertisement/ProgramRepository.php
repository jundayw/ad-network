<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Program;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ProgramRepository extends Repository
{
    public function __construct(
        private readonly Program $program
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->program
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('device'), function ($query) use ($request) {
                $query->where('device', $request->get('device'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->advertisement($request)
            ->oldest('state')
            ->latest($this->program->getKeyName());

        $data = $data->Paginate($request->get('per', $this->program->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->device  = $items->getDevice($items->device);
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('advertisement.program.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('advertisement.program.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'device' => $this->program->getDevice(),
            'state' => $this->program->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'device' => $this->program->getDevice(),
            'state' => $this->program->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): Program
    {
        $program = $this->program->create([
            'advertisement_id' => $request->user()->getAttribute('advertisement_id'),
            'title' => $request->get('title'),
            'device' => $request->get('device'),
            'limit' => $request->get('limit'),
            'state' => $request->get('state'),
        ]);

        if (is_null($program)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $program;
    }

    public function edit(Request $request): array
    {
        $data = $this->program->advertisement($request)->find($request->get($this->program->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'device' => $this->program->getDevice(),
            'state' => $this->program->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $program = $this->program->advertisement($request)->find($request->get($this->program->getKeyName()));

        if (is_null($program)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $program->update([
            'title' => $request->get('title'),
            'device' => $request->get('device'),
            'limit' => $request->get('limit'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        $program = $this->program->advertisement($request)->withCount('element')->find($request->get($this->program->getKeyName()));

        if (is_null($program)) {
            return false;
        }

        if ($program->element_count) {
            throw new RenderErrorResponseException("该广告计划下含有 {$program->element_count} 条广告单元，请先删除");
        }

        return $program->delete();
    }
}
