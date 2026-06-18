<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Price;
use App\Models\Profile;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda publik.
     */
    public function index()
    {
        $heroBanners = Banner::with('media')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $profile = Profile::with('media')
            ->where('is_active', true)
            ->first();

        $galleries = Gallery::with('media')
            ->latest()
            ->take(8)
            ->get();

        $facilities = Facility::with('media')
            ->latest()
            ->take(3)
            ->get();

        $prices = Price::with('media')
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $announcements = Announcement::with('photo')
            ->active()
            ->latest()
            ->take(3)
            ->get();

        $reviews = Review::with('user')
            ->visible()
            ->latest()
            ->take(3)
            ->get();

        $avgRating = Review::visible()->avg('rating') ?? 0;

        $totalFacilities = Facility::count();

        return view('public.home', compact(
            'heroBanners',
            'profile',
            'galleries',
            'facilities',
            'prices',
            'announcements',
            'reviews',
            'avgRating',
            'totalFacilities'
        ));
    }
}
