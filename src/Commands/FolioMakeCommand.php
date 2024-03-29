<?php

namespace Envor\OneApp\Commands;

use Laravel\Folio\Console\MakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'one-app:make-folio')]
class FolioMakeCommand extends MakeCommand
{
    use HasStubOption;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'one-app:make-folio';

    /**
     * Get the console command arguments.
     */
    protected function getOptions(): array
    {
        return [
            ['class', null, InputOption::VALUE_NONE, 'Create a class based component'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the Volt component even if the component already exists'],
            ['stub', 's', InputOption::VALUE_OPTIONAL, 'The stub file to use'],
        ];
    }
}
