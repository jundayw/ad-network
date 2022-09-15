<?php

namespace App\Http\Controllers\Publishment;

class UnCommonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest.publishment:publisher')->only(['login']);
    }
}
