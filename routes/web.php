<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ReviewController;

// Public home
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

        // Reviews
        Route::resource('reviews', ReviewController::class);
        Route::post('reviews/{review}/toggle-approval', [ReviewController::class, 'toggleApproval'])
            ->name('reviews.toggleApproval');
        Route::post('reviews/{id}/restore', [ReviewController::class, 'restore'])
            ->name('reviews.restore');
        Route::get('reviews-stats', [ReviewController::class, 'stats'])
            ->name('reviews.stats');

        // Prices
        Route::get('prices/foods/gallery', [App\Http\Controllers\Admin\PriceController::class, 'foodGallery'])
            ->name('prices.food.gallery');
        Route::resource('prices', App\Http\Controllers\Admin\PriceController::class);

        // Resource controllers
        Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
        Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
        Route::resource('profiles', App\Http\Controllers\Admin\ProfileController::class);
        Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class);
        Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);
        Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);

        // Announcements
        Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
        Route::patch('announcements/{announcement}/toggle', [App\Http\Controllers\Admin\AnnouncementController::class, 'toggle'])
            ->name('announcements.toggle');

        // Banners
        Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
        Route::patch('banners/{banner}/toggle', [App\Http\Controllers\Admin\BannerController::class, 'toggle'])
            ->name('banners.toggle');
    });
