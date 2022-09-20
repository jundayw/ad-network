<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Publisher;
use App\Models\Publishment;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ProfileRepository extends Repository
{
    public function __construct(
        private readonly Publisher $publisher,
        private readonly Publishment $publishment,
    )
    {
        //
    }

    public function password(Request $request): array
    {
        $data = $this->publisher->find($request->get($this->publisher->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [];

        return compact('filter', 'data');
    }

    public function updatePassword(Request $request): bool
    {
        $usersalt = generate_string();
        $userpass = password($request->get('password'), $usersalt);

        $data = $this->publisher->find($request->user()->getKey());

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'userpass' => $userpass,
            'usersalt' => $usersalt,
        ]);
    }

    public function updateInfo(Request $request)
    {
        $data = $this->publishment->find($request->user()->getAttribute('publishment_id'));

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        session()->remove('audit');

        return $data->update([
            'name' => $request->get('name'),
            'licence' => $request->get('licence'),
            'licence_image' => $request->get('licence_image'),
            'corporation' => $request->get('corporation'),
            'mobile' => $request->get('mobile'),
            'audit' => 'WAIT',
        ]);
    }
}
