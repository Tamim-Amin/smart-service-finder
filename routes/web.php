<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    
    // Customer Routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/search', [CustomerController::class, 'searchProviders'])->name('search');
        Route::get('/bookings', [CustomerController::class, 'myBookings'])->name('bookings');
    });

    // Provider Routes
    Route::prefix('provider')->name('provider.')->group(function () {
        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/create', [ProviderController::class, 'createProfile'])->name('profile.create');
        Route::post('/profile', [ProviderController::class, 'storeProfile'])->name('profile.store');
        Route::get('/profile/edit', [ProviderController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [ProviderController::class, 'updateProfile'])->name('profile.update');
    });

    // Booking Routes
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/create/{provider}', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::put('/{booking}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
    });

    // Review Routes
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/create/{booking}', [ReviewController::class, 'create'])->name('create');
        Route::post('/', [ReviewController::class, 'store'])->name('store');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/providers', [AdminController::class, 'providers'])->name('providers');
        Route::put('/providers/{provider}/verify', [AdminController::class, 'verifyProvider'])->name('providers.verify');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    });
});

require __DIR__.'/auth.php';
