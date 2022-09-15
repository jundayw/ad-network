<?php

namespace App\Http\Controllers\Backend;

class UnCommonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest.backend:manager')->only(['login']);
    }
}
