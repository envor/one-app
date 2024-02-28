<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\UserType;
use Envor\Datastore\Concerns\HasDatastores;
use Envor\Datastore\Concerns\JetstreamContext;
use Envor\Datastore\Contracts\HasDatastoreContext;
use Envor\Platform\Concerns\HasPlatformUuids;
use Envor\Platform\Concerns\UsesPlatformConnection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Passport\HasApiTokens;
use Parental\HasChildren;

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
    use HasChildren;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
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

    public function childTypes(): array
    {
        return array_column(UserType::cases(), 'value', 'name');
    }

    /**
     * Interact with the user's first name.
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->getReadableUserTypeName($value),
            set: fn (string|UserType $value) => $this->getStorableUserTypeName($value)
        );
    }

    protected function getStorableUserTypeName(string|UserType $value): string
    {
        if($value instanceof UserType){
            return $value->name;
        }
        
        if(!in_array($value, $this->childTypes()) && !in_array($value, array_keys($this->childTypes()))){
            throw new \Exception("Invalid user type: {$value}");
        }

        if(in_array($value, $this->childTypes())){
            return UserType::from($value)->name;
        }

        if(in_array($value, $this->childTypes())){
            return UserType::from($value)->name;
        }

        return $value;
    }

    protected function getReadableUserTypeName(string|UserType $value): UserType
    {
        if($value instanceof UserType){
            return $value;
        }

        if(!in_array($value, $this->childTypes()) && !in_array($value, array_keys($this->childTypes()))){
            throw new \Exception("Invalid user type: {$value}");
        }

        if(in_array($value, $this->childTypes())){
            return UserType::from($value);
        }

        return constant(UserType::class . '::' . $value);
    }
}
