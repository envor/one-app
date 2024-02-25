<?php

namespace Envor\OneApp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InvitationOnlyCommand extends Command
{
    public $signature = 'one-app:invitation-only';

    public $description = 'Require invitations to register';

    public function handle(): int
    {
        $this->info('Setting up invitation only registration...');
        $this->info('Publishing Stubs...');
        $this->copyFiles();
        $this->info('Invitation setup complete!');
        return 0;
    }

    protected function copyFiles()
    {
        $this->info('Copying files...');

        $sourceDir = realpath(__DIR__.'/../../stubs/invitation-only/');
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
