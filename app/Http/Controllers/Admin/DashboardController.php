<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\InformationRequest;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
    public function index()
    {
        // Statistik Dasar
        $totalUsers          = User::where('role', 'user')->count();
        $totalReviews        = Review::count();
        $totalAnnouncements  = Announcement::count();
        $activeAnnouncements = Announcement::active()->count();
        $totalGalleries      = Gallery::count();
        $averageRating       = Review::avg('rating') ?? 0;

        // Data Terbaru
        $recentReviews       = Review::with('user')->latest()->take(5)->get();
        $recentAnnouncements = Announcement::with('photo')->latest()->take(5)->get();

        // Distribusi Rating untuk Chart
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[] = Review::where('rating', $i)->count();
        }

        // Statistik Permintaan Informasi (Fitur Baru)
        $totalInformationRequests    = InformationRequest::count();
        $pendingInformationRequests  = InformationRequest::pending()->count();
        $answeredInformationRequests = InformationRequest::answered()->count();
        $closedInformationRequests   = InformationRequest::closed()->count();

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
            'totalInformationRequests',
            'pendingInformationRequests',
            'answeredInformationRequests',
            'closedInformationRequests',
        ));
    }
}
