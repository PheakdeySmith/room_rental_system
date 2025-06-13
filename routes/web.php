<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomTypeController;

Route::get('/unauthorized', function () {
    return view('backends.partials.errors.unauthorized');
})->name('unauthorized');

Route::get('/accessDenied', function () {
    return view('backends.partials.errors.access_denied');
})->name('accessDenied');

Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', function () {
    return view('backends.dashboard.home.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (global access)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
});

// Landlord Routes (tenant scoped)
Route::middleware(['auth', 'role:landlord'])
    ->prefix('landlord')
    ->name('landlord.')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('properties', PropertyController::class);
        Route::get('properties/{property}/create-price', [PropertyController::class, 'createPrice'])->name('properties.createPrice');
        Route::post('properties/{property}/store-price', [PropertyController::class, 'storePrice'])->name('properties.storePrice');
        Route::put('properties/{property}/update-price', [PropertyController::class, 'updatePrice'])->name('properties.updatePrice');
        Route::delete('properties/{property}/destroy-price', [PropertyController::class, 'destroyPrice'])->name('properties.destroyPrice');
        Route::resource('room_types', RoomTypeController::class);
        Route::resource('contracts', ContractController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('amenities', AmenityController::class);
});

// Tenant Routes (view only)
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
    // Define tenant routes here if any
});

require __DIR__.'/auth.php';