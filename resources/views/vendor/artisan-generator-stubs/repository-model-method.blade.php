<?php

namespace DummyNamespace;

use App\Exceptions\RenderErrorResponseException;
use DummyModelClassNamespace;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class DummyRepositoryClass extends Repository
{
    public function __construct(
        private readonly DummyModelClass $DummyModelVariable
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->DummyModelVariable
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->oldest('state')
            ->latest('sorting')
            ->latest($this->DummyModelVariable->getKeyName());

        $data = $data->Paginate($request->get('per', $this->DummyModelVariable->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = route('DummyRepositoryRoute.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = route('DummyRepositoryRoute.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'state' => $this->DummyModelVariable->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'state' => $this->DummyModelVariable->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): DummyModelClass
    {
        $DummyModelVariable = $this->DummyModelVariable->create([
            'title' => $request->get('title'),
            'state' => $request->get('state'),
        ]);

        if (is_null($DummyModelVariable)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $DummyModelVariable;
    }

    public function edit(Request $request): array
    {
        $data = $this->DummyModelVariable->find($request->get($this->DummyModelVariable->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'state' => $this->DummyModelVariable->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $DummyModelVariable = $this->DummyModelVariable->find($request->get($this->DummyModelVariable->getKeyName()));

        if (is_null($DummyModelVariable)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $DummyModelVariable->update([
            'title' => $request->get('title'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->DummyModelVariable->destroy($request->get($this->DummyModelVariable->getKeyName())) === 0);
    }
}
