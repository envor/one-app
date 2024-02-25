<?php

namespace Envor\OneApp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class OneAppCommand extends Command
{
    public $signature = 'one-app:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->info('Installing Jetstream...');

        $this->callSilent('jetstream:install', [
            'stack' => 'livewire',
            '--teams' => true,
            '--dark' => true,
            '--api' => true,
            '--pest' => true,
            '--no-interaction' => true,
        ]);

        $this->info('Installing folio...');

        $this->callSilent('folio:install');

        $this->info('Installing volt');

        $this->callSilent('volt:install');

        $this->info('Publishing Stubs...');

        $this->copyFiles();

        $this->info('One App installed');

        return 0;
    }

    protected function copyFiles()
    {
        $this->info('Copying files...');

        $sourceDir = realpath(__DIR__.'/../../stubs/one-app/');
        $destinationDir = base_path();

        $files = File::allFiles($sourceDir);

        foreach ($files as $file) {
            $destinationFilePath = $destinationDir.'/'.$file->getRelativePathname();
            File::ensureDirectoryExists(dirname($destinationFilePath));
            File::copy($sourceFile = $file->getPathname(), $destinationFilePath);
            // check verbosity
            if ($this->output->isVerbose()) {
                $this->line('<info>Copied</info> '.$sourceFile.' <info>to</info> '.$destinationFilePath);
            }
        }
    }
}
