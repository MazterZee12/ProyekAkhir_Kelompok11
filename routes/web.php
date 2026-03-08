<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReviewController;

// Public home (could redirect or show landing page)
Route::get('/', function () {
    return view('auth.login');
});

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])
     ->name('login');

Route::post('login', [AuthController::class, 'login'])
     ->name('login.post');

Route::post('logout', [AuthController::class, 'logout'])
     ->name('logout');

// Admin section routes
Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // statistics

        Route::resource('reviews', ReviewController::class);

        Route::post('reviews/{review}/toggle-approval',[ReviewController::class,'toggleApproval'])
            ->name('reviews.toggleApproval');

        Route::post('reviews/{id}/restore', [ReviewController::class,'restore'])
            ->name('reviews.restore');

        Route::get('reviews-stats', [ReviewController::class,'stats'])
            ->name('reviews.stats');

        // Profile (singleton)
        Route::get('profiles', [ProfileController::class, 'index'])
            ->name('profiles.index');
        Route::put('profiles', [ProfileController::class, 'update'])
            ->name('profiles.update');

        // Contact (singleton)
        Route::get('contacts', [ContactController::class, 'index'])
            ->name('contacts.index');
        Route::put('contacts', [ContactController::class, 'update'])
            ->name('contacts.update');

        Route::get('prices/foods/gallery', [App\Http\Controllers\Admin\PriceController::class, 'foodGallery'])
            ->name('prices.food.gallery');

        // resource controllers for CRUD management
        Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
        Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
        Route::resource('prices', App\Http\Controllers\Admin\PriceController::class);
        Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
        Route::patch('announcements/{announcement}/toggle', [App\Http\Controllers\Admin\AnnouncementController::class, 'toggle'])
            ->name('announcements.toggle');
});
