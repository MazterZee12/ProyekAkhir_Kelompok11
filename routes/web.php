<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\PublicController;

// ── Public routes ───────────────────────────────────────────
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])
    ->name('home');

Route::get('reviews', [\App\Http\Controllers\Public\ReviewController::class, 'index'])
    ->name('reviews.index');

// ── Auth required routes ────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('reviews/create',          [\App\Http\Controllers\Public\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews',                [\App\Http\Controllers\Public\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{review}/edit',   [\App\Http\Controllers\Public\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{review}',        [\App\Http\Controllers\Public\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}',     [\App\Http\Controllers\Public\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/{review}/report',[\App\Http\Controllers\Public\ReviewController::class, 'report'])->name('reviews.report');

    Route::get('information-requests',                           [\App\Http\Controllers\Public\InformationRequestController::class, 'index'])->name('information-requests.index');
    Route::get('information-requests/create',                    [\App\Http\Controllers\Public\InformationRequestController::class, 'create'])->name('information-requests.create');
    Route::post('information-requests',                          [\App\Http\Controllers\Public\InformationRequestController::class, 'store'])->name('information-requests.store');
    Route::get('information-requests/{informationRequest}',      [\App\Http\Controllers\Public\InformationRequestController::class, 'show'])->name('information-requests.show');
    Route::get('information-requests/{informationRequest}/edit', [\App\Http\Controllers\Public\InformationRequestController::class, 'edit'])->name('information-requests.edit');
    Route::put('information-requests/{informationRequest}',      [\App\Http\Controllers\Public\InformationRequestController::class, 'update'])->name('information-requests.update');
    Route::delete('information-requests/{informationRequest}',   [\App\Http\Controllers\Public\InformationRequestController::class, 'destroy'])->name('information-requests.destroy');

    // ── Ganti Password (harus login dulu) ──────────────────
    Route::get('ganti-password',  [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('ganti-password', [AuthController::class, 'changePassword'])->name('password.change.post');
});

// ── Public pages ────────────────────────────────────────────
Route::get('/about',         [PublicController::class, 'about'])->name('public.about');
Route::get('/facilities',    [PublicController::class, 'facilities'])->name('public.facilities');
Route::get('/gallery',       [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/pricing',       [PublicController::class, 'pricing'])->name('public.pricing');
Route::get('/schedule',      [PublicController::class, 'schedule'])->name('public.schedule');
Route::get('/faq',           [PublicController::class, 'faq'])->name('public.faq');
Route::get('/contact',       [PublicController::class, 'contact'])->name('public.contact');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('public.announcements');
Route::get('/announcements/{announcement}', [PublicController::class, 'announcementShow'])
    ->name('public.announcements.show');

// ── Authentication (guest only) ──────────────────────────────
Route::get('login',    [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login',   [AuthController::class, 'login'])->name('login.post');
Route::get('register',  [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout',   [AuthController::class, 'logout'])->name('logout');

// ── Lupa Password (tanpa email, password tampil di halaman) ─
Route::get('/lupa-password',  [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'resetPasswordSimple'])->name('password.email');

// ── Logout Session (timeout) ─────────────────────────────────
Route::get('/logout-session', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('info', 'Sesi kamu telah berakhir karena tidak aktif.');
})->name('logout.session');

// ── Chatbot ──────────────────────────────────────────────────
Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])
    ->name('chatbot.chat')
    ->middleware('throttle:30,1');

Route::get('/chatbot/status', [App\Http\Controllers\ChatbotController::class, 'status'])
    ->name('chatbot.status');

// ── Admin ─────────────────────────────────────────────────────
Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('reviews',    [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::patch('reviews/{review}/toggle-visibility', [ReviewController::class, 'toggleVisibility'])
            ->name('reviews.toggleVisibility');

        Route::resource('prices', App\Http\Controllers\Admin\PriceController::class);
        Route::patch('prices/{price}/toggle', [App\Http\Controllers\Admin\PriceController::class, 'toggle'])
            ->name('prices.toggle');

        Route::resource('galleries',     App\Http\Controllers\Admin\GalleryController::class);
        Route::resource('facilities',    App\Http\Controllers\Admin\FacilityController::class);
        Route::resource('profiles',      App\Http\Controllers\Admin\ProfileController::class);
        Route::resource('contacts',      App\Http\Controllers\Admin\ContactController::class);
        Route::resource('faqs',          App\Http\Controllers\Admin\FaqController::class);

        Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
        Route::patch('announcements/{announcement}/toggle',
            [App\Http\Controllers\Admin\AnnouncementController::class, 'toggle'])
            ->name('announcements.toggle');

        Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
        Route::patch('banners/{banner}/toggle',
            [App\Http\Controllers\Admin\BannerController::class, 'toggle'])
            ->name('banners.toggle');

        Route::get('information-requests', [App\Http\Controllers\Admin\InformationRequestController::class, 'index'])
            ->name('information-requests.index');
        Route::get('information-requests/{informationRequest}', [App\Http\Controllers\Admin\InformationRequestController::class, 'show'])
            ->name('information-requests.show');
        Route::patch('information-requests/{informationRequest}/answer', [App\Http\Controllers\Admin\InformationRequestController::class, 'answer'])
            ->name('information-requests.answer');
        Route::patch('information-requests/{informationRequest}/status', [App\Http\Controllers\Admin\InformationRequestController::class, 'updateStatus'])
            ->name('information-requests.status');
    });
