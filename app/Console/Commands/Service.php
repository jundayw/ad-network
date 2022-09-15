<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class Service extends GeneratorCommand
{
    protected $name = 'make:service';

    protected $description = 'Create a new service class';

    protected $type = 'Service';

    protected function getStub()
    {
        return __DIR__ . '/stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }
}
