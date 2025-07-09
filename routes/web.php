<?php

use App\Models\UtilityType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\UtilityRateController;
use App\Http\Controllers\UtilityTypeController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\PriceOverrideController;

Route::get('/unauthorized', function () {
    return view('backends.partials.errors.unauthorized');
})->name('unauthorized');

Route::get('/accessDenied', function () {
    return view('backends.partials.errors.access_denied');
})->name('accessDenied');

Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/dashboard', function () {
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
        Route::resource('utility_types', UtilityTypeController::class);
});

// Landlord Routes (tenant scoped)
Route::middleware(['auth', 'role:landlord'])
    ->prefix('landlord')    
    ->name('landlord.')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('properties', PropertyController::class);
        Route::post('/landlord/properties/{property}/rooms', [RoomController::class, 'storeRoom'])->name('properties.rooms.store');
        Route::get('properties/{property}/create-price', [PropertyController::class, 'createPrice'])->name('properties.createPrice');
        Route::post('properties/{property}/store-price', [PropertyController::class, 'storePrice'])->name('properties.storePrice');
        Route::put('properties/{property}/update-price', [PropertyController::class, 'updatePrice'])->name('properties.updatePrice');
        Route::delete('properties/{property}/destroy-price', [PropertyController::class, 'destroyPrice'])->name('properties.destroyPrice');
        Route::get('/properties/{property}/room-types/{roomType}/overrides', [PriceOverrideController::class, 'index'])->name('properties.roomTypes.overrides.index');
        Route::post('/properties/{property}/room-types/{roomType}/overrides', [PriceOverrideController::class, 'store'])->name('properties.roomTypes.overrides.store');
        Route::put('/properties/{property}/room-types/{roomType}/overrides/{override}', [PriceOverrideController::class, 'update'])->name('properties.roomTypes.overrides.update');
        Route::delete('/properties/{property}/room-types/{roomType}/overrides/{override}', [PriceOverrideController::class, 'destroy'])->name('properties.roomTypes.overrides.destroy');
        Route::resource('room_types', RoomTypeController::class);
        Route::resource('contracts', ContractController::class);
        Route::resource('rooms', controller: RoomController::class);
        Route::resource('amenities', AmenityController::class);
        Route::resource('payments', controller: PaymentController::class);

        // --- UTILITY RATE MANAGEMENT ROUTES FOR A SPECIFIC PROPERTY ---
        Route::get('/properties/{property}/rates', [UtilityRateController::class, 'index'])->name('properties.rates.index');
        Route::post('/properties/{property}/rates', [UtilityRateController::class, 'store'])->name('properties.rates.store');
        Route::put('/utility-rates/{rate}', [UtilityRateController::class, 'update'])->name('utility_rates.update');
        Route::delete('/utility-rates/{rate}', [UtilityRateController::class, 'destroy'])->name('utility_rates.destroy');
        // --- END OF UTILITY RATE ROUTES ---

        // --- METER MANAGEMENT ---
        Route::post('/meters', [MeterController::class, 'store'])->name('meters.store');
        Route::patch('/meters/{meter}', [MeterController::class, 'update'])->name('meters.update');
        Route::patch('/meters/{meter}/deactivate', [MeterController::class, 'deactivate'])->name('meters.deactivate');
        Route::patch('/meters/{meter}/toggle-status', [MeterController::class, 'toggleStatus'])->name('meters.toggle-status');
        Route::get('/meters/{meter}/history', [MeterController::class, 'getMeterHistory'])->name('meters.history');
        // --- END OF METER MANAGEMENT ---

        // --- METER READING MANAGEMENT ---
        Route::post('/meter-readings', [MeterReadingController::class, 'store'])->name('meter-readings.store');
        // --- END OF METER READING MANAGEMENT ---

});

// Tenant Routes (view only)
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->group(function () {

});

Route::get('/', [FrontendController::class,'index'])->name('frontend');

require __DIR__.'/auth.php';
