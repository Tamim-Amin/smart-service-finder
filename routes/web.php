<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;


// Welcome/Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route - Redirects based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }

    $userRole = $user->userRole;

    if (!$userRole) {
        return redirect()->route('login')->with('error', 'User role not assigned');
    }

    // Redirect based on role
    switch ($userRole->role) {
        case 'customer':
            return redirect()->route('customer.dashboard');
        case 'provider':
            return redirect()->route('provider.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard');
        default:
            return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Built-in Laravel Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Customer Routes

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    
    // Search Providers
    Route::get('/search', [CustomerController::class, 'searchProviders'])->name('search');
    
    // My Bookings
    Route::get('/bookings', [CustomerController::class, 'myBookings'])->name('bookings');
});

//  Provider Routes
Route::middleware(['auth', 'role:provider'])->prefix('provider')->name('provider.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile/create', [ProviderController::class, 'createProfile'])->name('profile.create');
    Route::post('/profile', [ProviderController::class, 'storeProfile'])->name('profile.store');
    Route::get('/profile/edit', [ProviderController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [ProviderController::class, 'updateProfile'])->name('profile.update');
    // Earnings Route
    Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings');
});

/*Booking Routes (Shared between Customer and Provider)*/
Route::middleware(['auth'])->prefix('bookings')->name('bookings.')->group(function () {
    // Create Booking (Customer only)
    Route::get('/create/{provider}', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    
    // Update Booking Status (Provider only)
    Route::put('/{booking}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
    
    // Cancel Booking (Customer only)
    Route::put('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
});

/* Review Routes (Customer only)*/
Route::middleware(['auth', 'role:customer'])->prefix('reviews')->name('reviews.')->group(function () {
    // Create Review
    Route::get('/create/{booking}', [ReviewController::class, 'create'])->name('create');
    Route::post('/', [ReviewController::class, 'store'])->name('store');
});

/* Admin Routes*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Provider Management
    Route::get('/providers', [AdminController::class, 'providers'])->name('providers');
    Route::put('/providers/{provider}/verify', [AdminController::class, 'verifyProvider'])->name('providers.verify');
    Route::delete('/providers/{provider}', [AdminController::class, 'deleteProvider'])->name('providers.delete');
    
    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // System Logs (Optional - for future implementation)
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

// Notification Routes
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::put('/{id}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
    Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unreadCount');
});

/*Public Routes (Optional - for viewing provider profiles publicly)*/
// View Provider Public Profile
Route::get('/providers/{provider}', [CustomerController::class, 'viewProvider'])->name('providers.show');

// Browse All Providers (Public)
Route::get('/browse', [CustomerController::class, 'browseProviders'])->name('browse');
require __DIR__.'/auth.php';