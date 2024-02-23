<?php

namespace App\Models;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Laravel\Jetstream\Membership as JetstreamMembership;

class Membership extends JetstreamMembership
{
    use UsesPlatformConnection;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
