<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Advertisement;
use App\Models\Advertiser;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ProfileRepository extends Repository
{
    public function __construct(
        private readonly Advertiser $advertiser,
        private readonly Advertisement $advertisement,
    )
    {
        //
    }

    public function password(Request $request): array
    {
        $data = $this->advertiser->find($request->get($this->advertiser->getKeyName()));

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

        $data = $this->advertiser->find($request->user()->getKey());

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
        $data = $this->advertisement->find($request->user()->getAttribute('advertisement_id'));

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
