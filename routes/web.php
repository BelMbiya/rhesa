<?php

use App\Livewire\HotelTable;
use App\Livewire\ClientRegistration;
use Illuminate\Support\Facades\Route;
use App\Livewire\FormStepper;

Route::redirect('/','dashboard');
Route::get('/enregistrement', FormStepper::class)
    ->name('form-stepper');

Route::get('/Recapitulatif/{id}', ClientRegistration::class)
    ->name('client-registration');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('hotels', HotelTable::class)
    ->middleware(['auth', 'verified'])
    ->name('hotels');
Route::get('hotel/{slug}', HotelTable::class)
    ->middleware(['auth', 'verified'])
    ->name('hotel');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
