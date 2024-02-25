<?php

namespace App\Models\Passport;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Laravel\Passport\AuthCode as PassportAuthCode;

class AuthCode extends PassportAuthCode
{
    use UsesPlatformConnection;
}
