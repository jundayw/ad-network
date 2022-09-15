<?php

namespace DummyNamespace;

use DummyModelClassNamespace;
use App\Repositories\Repository;

class DummyRepositoryClass extends Repository
{
    public function __construct(
        private readonly DummyModelClass $DummyModelVariable
    )
    {
        //
    }
}
