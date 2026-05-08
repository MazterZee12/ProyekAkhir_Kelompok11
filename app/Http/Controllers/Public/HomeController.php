<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Profile;
use App\Models\Gallery;
use App\Models\Facility;
use App\Models\Price;
use App\Models\Announcement;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda publik.
     */
    public function index()
    {
        $heroBanners     = Banner::where('is_active', true)->orderBy('order')->get();
        $profile         = Profile::where('is_active', true)->first();
        $galleries       = Gallery::where('status', 'published')->latest()->take(8)->get();
        $facilities      = Facility::latest()->take(3)->get();
        $prices          = Price::where('is_active', true)->latest()->take(3)->get();
        $announcements   = Announcement::where('is_active', true)->latest()->take(3)->get();
        $reviews         = Review::with('user')->latest()->take(3)->get();
        $avgRating       = Review::avg('rating') ?? 0;
        $totalFacilities = Facility::count();

        return view('public.home', compact(
            'heroBanners', 'profile', 'galleries', 'facilities',
            'prices', 'announcements', 'reviews', 'avgRating', 'totalFacilities'
        ));
    }
}
