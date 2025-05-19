<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('backends.dashboard.home.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

// Admin Routes (global access)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('contracts', ContractController::class);
    // Route::resource('rooms', RoomController::class);
    // Route::resource('users', UserController::class);
});

// Landlord Routes (tenant scoped)
Route::middleware(['auth', 'role:landlord'])->prefix('landlord')->group(function () {
    Route::resource('contracts', ContractController::class);
    Route::resource('rooms', RoomController::class);
});

// Tenant Routes (view only)
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {
    // Route::get('my-contracts', [TenantController::class, 'contracts'])->name('tenant.contracts');
});


require __DIR__.'/auth.php';
