<?php

namespace App\Http\Controllers\Publishment;

class AuthController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('policy');
    }
}
