<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Contact;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Price;
use App\Models\Profile;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function about()
    {
        $profile = Profile::with('media')->where('is_active', true)->first();
        $contact = Contact::where('is_active', true)->first();

        return view('public.about', compact('profile', 'contact'));
    }

    public function facilities()
    {
        $facilities = Facility::with('media')->latest()->get();

        return view('public.facilities', compact('facilities'));
    }

    public function gallery()
    {
        $galleries = Gallery::with('media')->latest()->paginate(12);

        return view('public.gallery', compact('galleries'));
    }

    public function pricing()
    {
        $tickets = Price::with('media')
            ->where('type', 'ticket')
            ->where('is_active', true)
            ->get();

        $rentals = Price::with('media')
            ->where('type', 'rental')
            ->where('is_active', true)
            ->get();

        return view('public.pricing', compact('tickets', 'rentals'));
    }

    public function announcements(Request $request)
    {
        $type = $request->query('type', 'all');

        $query = Announcement::with('photo')->active();

        if (in_array($type, ['event', 'promo', 'info'], true)) {
            $query->where('type', $type);
        }

        $announcements = $query->latest()->paginate(9);

        return view('public.announcements.index', compact('announcements', 'type'));
    }

    public function announcementShow(Announcement $announcement)
    {
        if ($announcement->status !== 'active') {
            abort(404);
        }

        $announcement->increment('views');

        $related = Announcement::with('photo')
            ->active()
            ->where('id', '!=', $announcement->id)
            ->where('type', $announcement->type)
            ->latest()
            ->take(3)
            ->get();

        return view('public.announcements.show', compact('announcement', 'related'));
    }

    public function faq()
    {
        $faqs = Faq::where('is_active', true)->orderBy('order')->get();

        return view('public.faq', compact('faqs'));
    }

    public function contact()
    {
        $contact = Contact::where('is_active', true)->first();

        return view('public.contact', compact('contact'));
    }
}
