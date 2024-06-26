<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use App\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return UserType::SuperAdmin === $user->type || UserType::UpgradedUser === $user->type;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool
    {
        return $user->ownsTeam($team) && false === cache()->get('team:lock_db:'. $team->uuid, false);
    }

    /**
     * Determine whether the user can add team members.
     */
    public function addTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can update team member permissions.
     */
    public function updateTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     */
    public function removeTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }
}
