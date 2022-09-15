<?php

namespace App\Repositories\Advertisement;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Advertiser;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ProfileRepository extends Repository
{
    public function __construct(
        private readonly Advertiser $advertisement,
    )
    {
        //
    }

    public function password(Request $request): array
    {
        $data = $this->advertisement->find($request->get($this->advertisement->getKeyName()));

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

        $data = $this->advertisement->find($request->user()->getKey());

        if (is_null($data)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $data->update([
            'userpass' => $userpass,
            'usersalt' => $usersalt,
        ]);
    }
}
