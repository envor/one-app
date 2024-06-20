<?php

namespace App\Models;

use Envor\Datastore\Concerns\BelongsToDatastore;
use Envor\Datastore\Contracts\ConfiguresDatastore;
use Envor\Platform\Concerns\HasContactData;
use Envor\Platform\Concerns\HasLandingPage;
use Envor\Platform\Concerns\HasPlatformUuids;
use Envor\Platform\Concerns\HasProfilePhoto;
use Envor\Platform\Concerns\UsesPlatformConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam implements ConfiguresDatastore
{
    use BelongsToDatastore;
    use HasContactData;
    use HasFactory;
    use HasLandingPage;
    use HasPlatformUuids;
    use HasProfilePhoto;
    use UsesPlatformConnection;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }

    protected function configured(): void
    {
        app()->forgetInstance('team');
        app()->forgetInstance('datastore_context');
        app()->instance('datastore_context', $this);
        app()->instance('team', $this);
    }
}
