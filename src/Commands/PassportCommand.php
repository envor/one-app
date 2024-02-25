<?php

namespace Envor\OneApp\Commands;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\File;
use Laravel\Passport\Passport;

class PassportCommand extends Command
{
    use UsesPlatformConnection;

    public $signature = 'one-app:passport {--force : Overwrite keys} {--length=4096 : Key length}';

    public $description = 'My command';

    public function handle(): int
    {

        $this->copyFiles();

        $this->simpleReplaceInFile('Laravel\\Sanctum\\HasApiTokens', 'Laravel\\Passport\\HasApiTokens', app_path('Models/User.php'));

        $provider = in_array('users', array_keys(config('auth.providers'))) ? 'users' : null;

        $this->call('passport:keys', ['--force' => $this->option('force'), '--length' => $this->option('length')]);

        $this->call('vendor:publish', ['--tag' => 'passport-migrations']);

        $this->moveMigrations();

        $this->configureUuids();

        app(DatabaseManager::class)->usingConnection($this->getConnectionName(), fn () => $this->call('migrate', [
            '--path' => 'database/migrations/platform',
        ]));

        $this->call('passport:client', ['--personal' => true, '--name' => config('app.name').' Personal Access Client']);
        $this->call('passport:client', ['--password' => true, '--name' => config('app.name').' Password Grant Client', '--provider' => $provider]);

        return 0;
    }

    /**
     * Configure Passport for client UUIDs.
     *
     * @return void
     */
    protected function configureUuids()
    {
        $this->call('vendor:publish', ['--tag' => 'passport-config']);

        config(['passport.client_uuids' => true]);
        Passport::setClientUuids(true);

        $this->replaceInFile(config_path('passport.php'), '\'client_uuids\' => false', '\'client_uuids\' => true');
        $this->replaceInFile(database_path('migrations/platform/****_**_**_******_create_oauth_auth_codes_table.php'), '$table->unsignedBigInteger(\'client_id\');', '$table->uuid(\'client_id\');');
        $this->replaceInFile(database_path('migrations/platform/****_**_**_******_create_oauth_access_tokens_table.php'), '$table->unsignedBigInteger(\'client_id\');', '$table->uuid(\'client_id\');');
        $this->replaceInFile(database_path('migrations/platform/****_**_**_******_create_oauth_clients_table.php'), '$table->bigIncrements(\'id\');', '$table->uuid(\'id\')->primary();');
        $this->replaceInFile(database_path('migrations/platform/****_**_**_******_create_oauth_personal_access_clients_table.php'), '$table->unsignedBigInteger(\'client_id\');', '$table->uuid(\'client_id\');');
    }

    protected function moveMigrations()
    {
        $this->info('Moving migrations...');

        $sourceDir = database_path('migrations');
        $destinationDir = database_path('migrations/platform');

        $files = File::allFiles($sourceDir);

        foreach ($files as $file) {
            if (str_contains($file->getFilename(), 'oauth')) {
                $destinationFilePath = $destinationDir.'/'.$file->getFilename();
                File::ensureDirectoryExists(dirname($destinationFilePath));
                File::move($sourceFile = $file->getPathname(), $destinationFilePath);
                // check verbosity
                if ($this->output->isVerbose()) {
                    $this->line('<info>Moved</info> '.$sourceFile.' <info>to</info> '.$destinationFilePath);
                }
            }
        }
    }

    protected function copyFiles()
    {
        $this->info('Copying files...');

        $sourceDir = realpath(__DIR__.'/../../passport/stubs/');
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

    /**
     * Replace a given string in a given file.
     *
     * @param  string  $path
     * @param  string  $search
     * @param  string  $replace
     * @return void
     */
    protected function replaceInFile($path, $search, $replace)
    {
        foreach (glob($path) as $file) {
            file_put_contents(
                $file,
                str_replace($search, $replace, file_get_contents($file))
            );
        }
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function simpleReplaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
