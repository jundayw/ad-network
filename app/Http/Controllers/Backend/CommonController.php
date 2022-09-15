<?php

namespace App\Http\Controllers\Backend;

class CommonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.backend:manager');
    }
}
