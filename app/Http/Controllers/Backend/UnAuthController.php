<?php

namespace App\Http\Controllers\Backend;

class UnAuthController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:manager');
    }
}
