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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LockScreenController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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
        
        // Admin Dashboard and Subscription Management
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Subscription Plans
        Route::get('/subscription-plans', [App\Http\Controllers\Admin\AdminDashboardController::class, 'subscriptionPlans'])->name('subscription-plans.index');
        Route::get('/subscription-plans/create', [App\Http\Controllers\Admin\AdminDashboardController::class, 'createSubscriptionPlan'])->name('subscription-plans.create');
        Route::post('/subscription-plans', [App\Http\Controllers\Admin\AdminDashboardController::class, 'storeSubscriptionPlan'])->name('subscription-plans.store');
        Route::get('/subscription-plans/{plan}/edit', [App\Http\Controllers\Admin\AdminDashboardController::class, 'editSubscriptionPlan'])->name('subscription-plans.edit');
        Route::put('/subscription-plans/{plan}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'updateSubscriptionPlan'])->name('subscription-plans.update');
        Route::delete('/subscription-plans/{plan}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'deleteSubscriptionPlan'])->name('subscription-plans.destroy');
        
        // User Subscriptions
        Route::get('/subscriptions', [App\Http\Controllers\Admin\AdminDashboardController::class, 'userSubscriptions'])->name('subscriptions.index');
        Route::get('/subscriptions/create', [App\Http\Controllers\Admin\AdminDashboardController::class, 'createUserSubscription'])->name('subscriptions.create');
        Route::post('/subscriptions', [App\Http\Controllers\Admin\AdminDashboardController::class, 'storeUserSubscription'])->name('subscriptions.store');
        Route::get('/subscriptions/{subscription}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'showUserSubscription'])->name('subscriptions.show');
        Route::post('/subscriptions/{subscription}/cancel', [App\Http\Controllers\Admin\AdminDashboardController::class, 'cancelUserSubscription'])->name('subscriptions.cancel');
        Route::post('/subscriptions/{subscription}/renew', [App\Http\Controllers\Admin\AdminDashboardController::class, 'renewUserSubscription'])->name('subscriptions.renew');
});

// Landlord Routes (tenant scoped)
Route::middleware(['auth', 'role:landlord', 'subscription.check'])
    ->prefix('landlord')    
    ->name('landlord.')
    ->group(function () {
        // Subscription management
        Route::get('/subscription/plans', [App\Http\Controllers\Landlord\SubscriptionController::class, 'plans'])
            ->name('subscription.plans');
        Route::get('/subscription/checkout/{plan}', [App\Http\Controllers\Landlord\SubscriptionController::class, 'checkout'])
            ->name('subscription.checkout');
        Route::post('/subscription/purchase/{plan}', [App\Http\Controllers\Landlord\SubscriptionController::class, 'purchase'])
            ->name('subscription.purchase');
        Route::get('/subscription/success/{subscription}', [App\Http\Controllers\Landlord\SubscriptionController::class, 'success'])
            ->name('subscription.success');
        
        // Test route for null rent_amount
        
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

        // --- Payment MANAGEMENT ---
        Route::resource('payments', controller: PaymentController::class);
        Route::get('/payments/get-contract-details/{contract}', [PaymentController::class, 'getContractDetails'])->name('payments.getContractDetails');
        Route::get('/payments/filter', [PaymentController::class, 'filter'])->name('payments.filter');
        Route::patch('/payments/{invoice}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');

        // --- END OF PAYMENT MANAGEMENT ---

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
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\TenantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoices', [App\Http\Controllers\TenantDashboardController::class, 'allInvoices'])->name('invoices');
    Route::get('/invoices/{invoice}/details', [App\Http\Controllers\TenantDashboardController::class, 'getInvoiceDetails'])->name('invoices.details');
    Route::get('/utility-bills', [App\Http\Controllers\TenantDashboardController::class, 'allUtilityBills'])->name('utility-bills');
    Route::get('/utility-usage', [App\Http\Controllers\TenantDashboardController::class, 'utilityUsage'])->name('utility-usage');
    Route::get('/profile', [App\Http\Controllers\TenantDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\TenantDashboardController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/', [FrontendController::class,'index'])->name('frontend');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/lock-screen', [LockScreenController::class, 'show'])->name('lockscreen.show');
    Route::post('/lock-screen', [LockScreenController::class, 'unlock'])->name('lockscreen.unlock');
    Route::post('/lockscreen/logout', [LockScreenController::class, 'logout'])->name('lockscreen.logout');
});
