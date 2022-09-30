<?php

namespace App\Repositories\Analysis;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class AnalysisRepository extends Repository
{
    public function __construct()
    {
        //
    }

    public function review(Request $request)
    {
        dd($request->all());
        return [];
    }

    public function redirect(Request $request)
    {
        dd($request->all());
        return [];
    }
}
