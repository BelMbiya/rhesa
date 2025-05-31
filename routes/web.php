<?php

use App\Livewire\ClientRegistration;
use Illuminate\Support\Facades\Route;
use App\Livewire\FormStepper;

Route::view('/', 'welcome');
Route::get('/enregistrement', FormStepper::class)
    ->name('form-stepper');

Route::get('/Recapitulatif/{id}', ClientRegistration::class)
    ->name('client-registration');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
