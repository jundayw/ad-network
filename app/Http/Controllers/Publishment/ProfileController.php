<?php

namespace App\Http\Controllers\Publishment;

use App\Http\Requests\Publishment\ProfilePasswordRequest;
use App\Http\Responses\RenderResponse;
use App\Http\Responses\ViewResponse;
use App\Repositories\Publishment\ProfileRepository;
use Illuminate\Http\Request;

/**
 * @module 信息
 * @controller 个人信息
 */
class ProfileController extends CommonController
{
    public function __construct(
        private readonly ProfileRepository $repository,
    )
    {
        parent::__construct();
    }

    /**
     * @action 修改密码
     */
    public function password(ProfilePasswordRequest $request): RenderResponse|ViewResponse
    {
        if ($request->isMethod('POST')) {
            $this->repository->updatePassword($request);
            return new RenderResponse('操作成功', route('publishment.profile.password'));
        }
        $data = $request->user();
        return new ViewResponse(compact('data'));
    }
}
