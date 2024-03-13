<?php

namespace App\Console\Commands;

use Envor\Datastore\Models\Datastore;
use Illuminate\Console\Command;
use Laravel\Pennant\Feature;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class ToggleFeaturesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'features:toggle {--feature= : The feature to activate.} {--datastore= : The datastore to toggle it for.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Datastore::count() === 0) {
            $this->error('No datastores found. Please create a datastore first.');

            return;
        }

        if (count(Feature::all()) === 0) {
            $this->error('No features found. Please create a feature first.');

            return;
        }

        $features = $this->option('feature') ?? multiselect('Which features would you like to toggle?', collect(Feature::all())->keys()->all());

        $selecteDatastore = $this->option('datastore') ?? select('Which datastore would you like to toggle them for?', Datastore::all()->mapWithKeys(fn ($datastore) => [
            $datastore->uuid => $datastore->name,
        ])->toArray());

        $datastore = Datastore::where('uuid', $selecteDatastore)->first();

        foreach ($features as $feature) {
            $this->toggleFeature($feature, $datastore);
            match (Feature::for($datastore)->active($feature)) {
                true => $this->info("Feature: {$feature} is now active for datastore: {$datastore->name}"),
                false => $this->info("Feature: {$feature} is now inactive for datastore: {$datastore->name}"),
            };
        }
    }

    protected function toggleFeature($feature, $datastore)
    {
        $this->info("Toggling feature: {$feature} for datastore: {$datastore->name}");
        match (Feature::for($datastore)->active($feature)) {
            true => Feature::for($datastore)->deactivate($feature),
            false => Feature::for($datastore)->activate($feature),
        };
    }
}
