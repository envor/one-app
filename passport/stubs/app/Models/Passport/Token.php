<?php

namespace App\Models\Passport;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Laravel\Passport\Token as PassportToken;

class Token extends PassportToken
{
    use UsesPlatformConnection;
}
