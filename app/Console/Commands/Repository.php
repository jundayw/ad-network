<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class Repository extends GeneratorCommand
{
    protected $name = 'make:repository';

    protected $description = 'Create a new repository class';

    protected $type = 'Repository';

    protected function getStub()
    {
        return __DIR__ . '/stubs/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }
}
