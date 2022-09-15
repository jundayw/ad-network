<?php

namespace App\Http\Controllers\Advertisement;

class CommonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.advertisement:advertiser');
    }
}
