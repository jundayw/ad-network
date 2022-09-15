<?php

namespace App\Http\Controllers\Publishment;

class CommonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.publishment:publisher');
    }
}
