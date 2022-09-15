<?php

namespace App\Repositories;

use App\Support\Traits\AuthGuardTrait;
use App\Support\Traits\NamespaceControllerActionNameTrait;

abstract class Repository
{
    use AuthGuardTrait;
    use NamespaceControllerActionNameTrait;
}
