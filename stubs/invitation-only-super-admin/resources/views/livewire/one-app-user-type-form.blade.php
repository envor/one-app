<?php

use App\Models\User;
use Envor\Datastore\Models\Datastore;
use Illuminate\Validation\Rule;

use function Livewire\Volt\{computed, state, mount};

state([
    'user' => null,
    'data' => [],
]);

mount(
    function ($user) {
        $this->user = $user;

        $this->data['user_type'] = $user->type->name;
    }
);

$availableTypes = computed(fn() => (new User)->childTypes());

$updateUserType = function () {

    $this->resetErrorBag();

    $this->validate([
        'data.user_type' => [Rule::in(array_keys((new User)->childTypes()))],
    ]);

    $this->user->forceFill([
        'type' => $this->data['user_type'],
    ])->save();


    $this->dispatch('saved');
};?>

<x-form-section submit="updateUserType">
    <x-slot name="title">
        {{ __('User Type') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The Type of user') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('User Type') }}" />

            <x-select id="name" type="text" class="block w-full mt-1" wire:model="data.user_type" autofocus>
                @foreach ($this->availableTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </x-select>

            <x-input-error for="data.user_type" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
