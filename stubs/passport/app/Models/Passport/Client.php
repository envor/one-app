<?php

namespace App\Models\Passport;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    use UsesPlatformConnection;
}
