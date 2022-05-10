<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

class ServiceContractCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $name = 'make:service-contract';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new service contract';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'ServiceContract';

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return string
     */
    protected function replaceClass ($stub, $name) : string
    {
        $model = $this->argument('name');

        if (!$this->argument('name'))
        {
            throw new InvalidArgumentException("Missing required argument model name");
        }

        $stub = parent::replaceClass($stub, $name);

        return str_replace('Dummy', $model, $stub);
    }

    protected function getNameInput () : string
    {
        return parent::getNameInput() . 'ServiceContract';
    }

    /**
     * Get the stub file for the generator.
     * @return string
     */
    protected function getStub () : string
    {
        return base_path('stubs/service.contract.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace ($rootNamespace) : string
    {
        return $rootNamespace . '/Services/Contracts';
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments () : array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model class.'],
        ];
    }
}
