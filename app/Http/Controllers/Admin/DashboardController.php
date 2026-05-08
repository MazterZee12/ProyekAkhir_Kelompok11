<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use App\Models\Announcement;
use App\Models\Gallery;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
{
    $totalUsers          = User::where('role', 'user')->count();
        $totalReviews        = Review::count();
        $totalAnnouncements  = Announcement::count();
        $activeAnnouncements = Announcement::where('is_active', true)->count();
        $totalGalleries      = Gallery::count();
        $recentReviews       = Review::with('user')->latest()->take(5)->get();
        $recentAnnouncements = Announcement::latest()->take(5)->get();
        $averageRating       = Review::avg('rating') ?? 0;

        /**
         * Distribusi rating 1 sampai 5
         */
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[] = Review::where('rating', $i)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalReviews',
            'totalAnnouncements',
            'activeAnnouncements',
            'totalGalleries',
            'recentReviews',
            'recentAnnouncements',
            'ratingDistribution',
            'averageRating',
        ));
    }
}
