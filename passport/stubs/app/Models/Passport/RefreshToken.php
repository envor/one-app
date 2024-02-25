<?php

namespace App\Models\Passport;

use Envor\Platform\Concerns\UsesPlatformConnection;
use Laravel\Passport\RefreshToken as PassportRefreshToken;

class RefreshToken extends PassportRefreshToken
{
    use UsesPlatformConnection;
}
