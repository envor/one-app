<?php

namespace App\Providers;

use App\Models\Team;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRequests();
        $this->configureQueue();
    }

    public function configureRequests()
    {
        if ($this->app->environment('production')) {
            $this->app['url']->forceScheme('https');
        }

        if (! $this->app->runningInConsole()) {
            $domain = $this->app->request->getHost();

            /** @var \App\Models\Team $team
             * query to see if a team owns the current domain
             */
            $team = Team::where('domain', $domain)->first();

            if (isset($team->id) && isset($team->datastore_id)) {

                // migrate only once a day
                if (! cache()->has('team_migrated_'.$team->id)) {
                    $team
                        ->migrate();
                    cache()->put('team_migrated_'.$team->id, true, now()->addDay());
                }

                $team->configure()->use();
            }
        }
    }

    public function configureQueue()
    {
        if (isset($this->app['team'])) {
            $this->app['queue']->createPayloadUsing(function () {
                return $this->app['team'] ? [
                    'team_uuid' => $this->app['team']->uuid,
                ] : [];
            });
        }

        $this->app['events']->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload['team_uuid'])) {
                $team = Team::whereUuid($event->job->payload['team_uuid'])->first();
                if (isset($team->id)) {
                    $team->configure()->use();
                }
            }
        });
    }
}
