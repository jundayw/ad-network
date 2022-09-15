<?php

namespace DummyNamespace;

use DummyRepositoryClassNamespace;

/**
 * @module DummyLabel
 * @controller DummyLabel管理
 */
class DummyControllerClass extends AuthController
{
    public function __construct(private readonly DummyRepositoryClass $repository)
    {
        parent::__construct();
    }
}
