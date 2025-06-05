<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;

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
    ->name('admin.') // This is great! Routes will be admin.users.index, admin.users.store, etc.
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('contracts', ContractController::class);
        // Route::resource('rooms', RoomController::class); // Ensure only one users resource if uncommented
});

// Landlord Routes (tenant scoped)
Route::middleware(['auth', 'role:landlord'])
    ->prefix('landlord')
    ->name('landlord.') // <-- ADD THIS FOR LANDLORD ROUTES
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('contracts', ContractController::class);
        Route::resource('rooms', RoomController::class);
});

// Tenant Routes (view only)
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
    // Define tenant routes here if any
});

require __DIR__.'/auth.php';