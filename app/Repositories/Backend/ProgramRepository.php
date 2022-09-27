<?php

namespace App\Repositories\Backend;

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
            ->withWhereHas('advertisements', function ($query) use ($request) {
                $query->when($request->get('advertisement'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->get('advertisement')}%");
                });
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('device'), function ($query) use ($request) {
                $query->where('device', $request->get('device'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest($this->program->getKeyName());

        $data = $data->Paginate($request->get('per', $this->program->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->device  = $items->getDevice($items->device);
            $items->state   = $items->getState($items->state);
            $items->edit    = route('backend.program.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('backend.program.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'device' => $this->program->getDevice(),
            'state' => $this->program->getState(),
        ];

        return compact('filter', 'data');
    }

    public function edit(Request $request): array
    {
        $data = $this->program->find($request->get($this->program->getKeyName()));

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
        $program = $this->program->find($request->get($this->program->getKeyName()));

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
        return !($this->program->destroy($request->get($this->program->getKeyName())) === 0);
    }
}
