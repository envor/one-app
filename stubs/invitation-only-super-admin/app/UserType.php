<?php

namespace App;

use App\Models\SuperAdmin;
use App\Models\User;

enum UserType: string
{
    case User = User::class;
    case SuperAdmin = SuperAdmin::class;
    case UpgradedUser = UpgradedUser::class;
}
