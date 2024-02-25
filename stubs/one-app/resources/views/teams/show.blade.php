<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (Gate::check('update', $team))
                @livewire('update-belongs-to-datastore-form', ['model' => $team])
                <x-section-border />
            @endif

            @livewire('teams.update-team-name-form', ['team' => $team])

            <x-section-border />
            @livewire('update-contact-info-form', ['model' => $team, 'readonly' => ! Gate::check('update', $team)])

            @if (Gate::check('update', $team))
            <x-section-border />
                @livewire('update-logo-form', ['model' => $team])
            @endif

            @if (Gate::check('update', $team))
                <x-section-border />
                @livewire('update-landing-page-form', ['model' => $team])
            @endif

            @if (Gate::check('update', $team))
                <x-section-border />
                @livewire('update-model-domain-form', ['model' => $team, 'readonly' => ! Gate::check('update', $team)])
            @endif

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
