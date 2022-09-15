<?php

namespace App\Http\Controllers\Advertisement;

class UnCommonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest.advertisement:advertiser')->only(['login']);
    }
}
