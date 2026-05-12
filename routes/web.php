<?php

use App\Livewire\hotel\Hotelshow;
use App\Livewire\hotel\HotelTable;
use App\Livewire\client\ClientRegistration;
use App\Livewire\utilisateur\UserShow;
use App\Models\client;
use App\Models\hotel;
use Illuminate\Support\Facades\Route;
use App\Livewire\FormStepper;
use App\Controller\HotelDelete;
use App\Livewire\hotel\HotelRegistration;
use App\Livewire\hotel\HotelUpdate;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Livewire\utilisateur\UsersTable;
use App\Livewire\utilisateur\UserRegistration;
use App\Livewire\utilisateur\UserTable;
use App\Http\Controllers\UserController;
use App\Livewire\utilisateur\UserUpdate;
use App\Livewire\hotel\HotelDashboard;
use App\Livewire\hotel\HotelClientManagement;
use App\Livewire\client\ClientDetail;

Route::redirect('/','dashboard');
Route::get('/enregistrement/{slug}', FormStepper::class)
    ->name('form-stepper');

Route::get('/Recapitulatif/{id}', ClientRegistration::class)
    ->name('client-registration');

Route::get('/summery/{id}', ClientDetail::class)
    ->name('client-detail');

// routes/web.php
Route::get('/recapitulatif/{id}/download', function ($id) {
    ini_set('memory_limit', '512M');

    $client       = \App\Models\Client::findOrFail($id);
    $stay         = $client->stays()->latest()->first();
    $registration = $stay?->registration;

    $hotelName = $registration
        ? \App\Models\Hotel::find($registration->hotel_id)?->name
        : '';
    $regTime = $registration?->registration_time ?? '';
    $regDate = $registration?->registration_date ?? '';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.client-registration', [
        'client'     => $client,
        'hotel_name' => $hotelName,
        'reg_time'   => $regTime,
        'reg_date'   => $regDate,
        'isPdf'      => true,
    ])->setPaper('a4', 'portrait');

    return $pdf->download('client-registration.pdf');

})->middleware(['auth'])->name('client-registration.download');

Route::get('/hotel/registration', ClientRegistration::class)
    ->middleware(['auth', 'verified'])
    ->name('client-registration');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('hotels', HotelTable::class)
    ->middleware(['auth', 'verified'])
    ->name('hotels');
Route::get('hotel/delete/{id}', [App\Http\Controllers\HotelController::class, 'delete'])
    ->middleware(['auth', 'verified'])
    ->name('hotel-delete');
Route::get('/hotel/update/{id}', HotelUpdate::class)
    ->middleware(['auth', 'verified'])
    ->name('hotel-update');
Route::get('/hotel/registration', HotelRegistration::class)
    ->middleware(['auth', 'verified'])
    ->name('hotel-registration');
Route::get('hotel/{slug}', hotelshow::class)
    ->middleware(['auth', 'verified'])
    ->name('hotel');


Route::get('/users', UserTable::class)
    ->middleware(['auth', 'verified'])
    ->name('users.index');
Route::get('/users/create', UserRegistration::class)
    ->middleware(['auth', 'verified'])
    ->name('users.create');
Route::get('/users/{user}', UserShow::class)
    ->middleware(['auth', 'verified'])
    ->name('users.show');
Route::get('/users/{user}/edit', UserUpdate::class)
    ->middleware(['auth', 'verified'])
    ->name('users.edit');
Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('users.destroy');



// routes/web.php — ajouter dans le groupe auth

Route::middleware(['auth', 'verified'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', HotelDashboard::class)
        ->name('dashboard');
    Route::get('/clients', HotelClientManagement::class)
        ->name('clients');
    
Route::get('/summery/{id}', ClientDetail::class)
->name('client-detail');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
