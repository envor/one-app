<?php

namespace App\Console\Commands;

use Envor\Datastore\Models\Datastore;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DatastoreRunCommand extends Command
{
    public $signature = 'datastores:run {artisanCommand?} {--datastore= : The datastore to run the command on} {--driver=sqlite}';

    public $description = 'Run an artisan command on a datastore database';

    public function handle(): int
    {

        if (! $artisanCommand = $this->argument('artisanCommand')) {
            $question = $this->option('datastore')
                ? 'Which artisan command do you want to run for '.$this->option('datastore').'?'
                : 'Which artisan command do you want to run for all datastores?';
            $artisanCommand = $this->ask($question);
        }

        $artisanCommandCallback = function () use ($artisanCommand) {
            $this->info('Running '.$artisanCommand.' on '.config('database.default').'...');

            return Artisan::call($artisanCommand, [], $this->output);
        };

        if ($databaseName = $this->option('datastore')) {
            $datastore = Datastore::where('name', $databaseName)->first();

            if (! $datastore) {
                $this->error('Datastore "'.$databaseName.'" not found.');

                return 1;
            }

            $datastore->database()->run($artisanCommandCallback)->disconnect();
        } else {
            Datastore::all()->each(function ($datastore) use ($artisanCommandCallback) {
                $datastore->database()->run($artisanCommandCallback)->disconnect();
            });
        }

        return 0;
    }
}
