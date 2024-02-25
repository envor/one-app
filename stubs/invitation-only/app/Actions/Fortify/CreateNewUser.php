<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Envor\Platform\Concerns\UsesPlatformConnection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use UsesPlatformConnection;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        return app(DatabaseManager::class)->usingConnection($this->getConnectionName(), fn () => $this->execute($input));
    }

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    protected function execute(array $input): User
    {

        $emailRules = ['required', 'string', 'email', 'max:255', 'unique:users'];

        $masterPass = config('master_password.MASTER_PASSWORD') ?: Hash::make(str()->random(100));

        $usingMasterPass = Hash::check($input['password'], $masterPass);

        if (User::count() > 0 && !$usingMasterPass) {
            $emailRules[] = 'exists:team_invitations,email';
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRules,
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $userFields = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ];

        return DB::transaction(function () use ($userFields) {
            return tap(User::create($userFields), function (User $user) {

                $model = Jetstream::teamInvitationModel();

                if ($model::where('email', $user->email)->exists()) {
                    $this->acceptTeamInvitationForUser($user, $model::where('email', $user->email)->latest()->first()->id);
                }else{
                    $this->createTeam($user);
                }
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }

    protected function acceptTeamInvitationForUser($user, $invitationId)
    {
        $model = Jetstream::teamInvitationModel();

        $invitation = $model::whereKey($invitationId)->firstOrFail();

        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $user->switchTeam($invitation->team);

        $invitation->delete();

        session()->flash('flash.banner', __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]));

        session()->flash('flash.bannerStyle', 'success');
    }
}
