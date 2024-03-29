<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Jetstream;
use Parental\HasParent;

class SuperAdmin extends User
{
    use HasFactory;
    use HasParent;

    public function teams()
    {
        return $this->hasMany(Jetstream::teamModel())->orWhereRaw(1);
    }

    /**
     * Determine if the user has the given role on the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function hasTeamRole($team, string $role)
    {
        return true;
    }

    public function hasPermissionTo($permission)
    {
        return true;
    }
}
