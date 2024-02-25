<?php

namespace App\Models\Passport;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class PersonalAccessClient extends PassportPersonalAccessClient
{
    use UsesPlatformConnection;
}
