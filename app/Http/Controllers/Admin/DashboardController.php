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
        $totalUsers         = User::where('role', 'visitor')->count();
        $totalReviews       = Review::count();
        $pendingReviews     = Review::pending()->count();
        $approvedReviews    = Review::approved()->count();
        $recentReviews      = Review::with('user')->latest()->take(5)->get();
        $totalAnnouncements = Announcement::count();
        $activeAnnouncements = Announcement::where('is_active', true)->count();
        $totalGalleries     = Gallery::count();
        $recentReviews      = Review::with('user')->latest()->take(5)->get();
        $recentAnnouncements = Announcement::latest()->take(5)->get();

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
            'pendingReviews',
            'approvedReviews',
            'totalAnnouncements',
            'activeAnnouncements',
            'totalGalleries',
            'recentReviews',
            'recentAnnouncements',
            'ratingDistribution'
        ));
    }
}
