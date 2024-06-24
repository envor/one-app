<?php

use Laravel\Jetstream\Jetstream;

use function Livewire\Volt\{state, mount};
 
state(['team' => null]);

mount(fn($team) => $this->team = $team);

$switchTeam = function() {
    if (! auth()->user()->switchTeam($this->team)) {
        abort(403);
    }

    $this->js('window.location.reload()');
};
 
?>
 
<div>
    <form wire:submit="switchTeam">

        <x-dropdown-link href="#" wire:click="switchTeam">
            <div class="flex items-center">
                @if (Auth::user()->isCurrentTeam($this->team))
                    <svg class="w-5 h-5 text-green-400 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif

                <div class="truncate">{{ $this->team->name }}</div>
            </div>
        </x-dropdown-link>
</form>
</div>


