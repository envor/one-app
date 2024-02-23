<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Envor\Datastore\Concerns\HasDatastores;
use Envor\Datastore\Concerns\JetstreamContext;
use Envor\Datastore\Contracts\HasDatastoreContext;
use Envor\Platform\Concerns\HasPlatformUuids;
use Envor\Platform\Concerns\UsesPlatformConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements HasDatastoreContext
{
    use HasApiTokens;
    use HasDatastores;
    use HasFactory;
    use HasPlatformUuids;
    use HasProfilePhoto;
    use HasTeams;
    use JetstreamContext;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UsesPlatformConnection;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
