<?php

use App\Models\User;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

test('registration requires invitation', function () {
    $user = User::factory()->create();

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'uninvited@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('users can register with a valid invitation', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $invitation = $user->currentTeam->teamInvitations()->create([
        'email' => 'invited@example.com',
        'role' => 'admin',
    ]);

    $response = $this->post('/register', [
        'name' => 'Test Invited User',
        'email' => 'invited@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertEquals($invitation->id, User::where('email', 'invited@example.com')->first()->currentTeam->id);
    expect(session('flash.bannerStyle'))->toBe('success');
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');
