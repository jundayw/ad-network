<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class Response extends GeneratorCommand
{
    protected $name = 'make:response';

    protected $description = 'Create a new response class';

    protected $type = 'Response';

    protected function getStub()
    {
        $stub = '/stubs/response.stub';

        if ($this->option('parent') == 'view') {
            $stub = '/stubs/response.view.stub';
        }

        if ($this->option('parent') == 'redirect') {
            $stub = '/stubs/response.redirect.stub';
        }

        return __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Responses';
    }

    protected function getOptions()
    {
        return [
            ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],
        ];
    }
}
