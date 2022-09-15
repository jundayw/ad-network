<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class Entity extends GeneratorCommand
{
    protected $name = 'make:entity';

    protected $description = 'Create a new entity class';

    protected $type = 'Entity';

    protected function getStub()
    {
        return __DIR__ . '/stubs/entity.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Entities';
    }
}
