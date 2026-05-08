<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\PublicController;

// Public routes
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])
    ->name('home');

// Public reviews
Route::get('reviews', [\App\Http\Controllers\Public\ReviewController::class, 'index'])
    ->name('reviews.index');

Route::middleware('auth')->group(function () {
    Route::get('reviews/create',  [\App\Http\Controllers\Public\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews',        [\App\Http\Controllers\Public\ReviewController::class, 'store'])->name('reviews.store');
    Route::post('reviews/{review}/report', [\App\Http\Controllers\Public\ReviewController::class, 'report'])->name('reviews.report');
    Route::delete('reviews/{review}',      [\App\Http\Controllers\Public\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Public pages
Route::get('/about',         [PublicController::class, 'about'])->name('public.about');
Route::get('/facilities',    [PublicController::class, 'facilities'])->name('public.facilities');
Route::get('/gallery',       [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/pricing',       [PublicController::class, 'pricing'])->name('public.pricing');
Route::get('/schedule',      [PublicController::class, 'schedule'])->name('public.schedule');
Route::get('/faq',           [PublicController::class, 'faq'])->name('public.faq');
Route::get('/contact',       [PublicController::class, 'contact'])->name('public.contact');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('public.announcements');
Route::get('/announcements/{slug}', [PublicController::class, 'announcementShow'])->name('public.announcements.show');

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])
    ->name('login');
Route::post('login', [AuthController::class, 'login'])
    ->name('login.post');
Route::get('register', [AuthController::class, 'showRegisterForm'])
    ->name('register');
Route::post('register', [AuthController::class, 'register'])
    ->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/logout-session', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('info', 'Sesi kamu telah berakhir karena tidak aktif.');
})->name('logout.session');

Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])
    ->name('chatbot')
    ->middleware('throttle:30,1'); // maks 30 request per menit per IP

// Admin section routes
Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Reviews
        Route::resource('reviews', ReviewController::class);
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
