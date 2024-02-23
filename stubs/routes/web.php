<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $team = isset(app()['team']) ? app()['team'] : null;

    if ($team?->landingPage) {
        return response()->file(Storage::disk($team->landingPageDisk())->path($team->landingPagePath()));
    }

    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
