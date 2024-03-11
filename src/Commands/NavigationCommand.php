<?php

namespace Envor\OneApp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class NavigationCommand extends Command
{
    public $signature = 'one-app:navigation';

    public $description = 'install one-app navigation';

    public function handle(): int
    {
        $this->info('Setting up navigation...');
        $this->info('Publishing Stubs...');
        $this->copyFiles();
        $this->info('Navigation setup complete!');

        return 0;
    }

    protected function copyFiles(string $from = 'navigation')
    {
        $this->info('Copying files...');

        $sourceDir = realpath(__DIR__.'/../../stubs/'.$from);
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
