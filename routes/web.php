<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAdmin;

// Public home (could redirect or show landing page)
Route::get('/', function () {
    return view('admin.dashboard');
});

// Admin section routes
Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // statistics
        Route::get('stats/users', [App\Http\Controllers\Admin\UserStatsController::class, 'index'])
            ->name('stats.users');
        Route::get('stats/reviews', [App\Http\Controllers\Admin\ReviewStatsController::class, 'index'])
            ->name('stats.reviews');

        // resource controllers for CRUD management
        Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
        Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
        Route::resource('prices', App\Http\Controllers\Admin\PriceController::class);
        Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
        Route::resource('profiles', App\Http\Controllers\Admin\ProfileController::class);
        Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class);
        Route::resource('reviews', App\Http\Controllers\Admin\ReviewModerationController::class);
});
