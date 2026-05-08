<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Contact;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Price;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    // /about
    public function about()
    {
        $profile = Profile::where('is_active', true)->first();
        $contact = Contact::where('is_active', true)->first();
        return view('public.about', compact('profile', 'contact'));
    }

    // /facilities
    public function facilities()
    {
        $facilities = Facility::latest()->get();
        return view('public.facilities', compact('facilities'));
    }

    // /gallery
    public function gallery(Request $request)
    {
        $type  = $request->query('type', 'all');
        $query = Gallery::where('status', 'published');
        if (in_array($type, ['photo', 'video'])) {
            $query->where('type', $type);
        }
        $galleries = $query->latest()->paginate(12);
        return view('public.gallery', compact('galleries', 'type'));
    }

    // /pricing
    public function pricing()
    {
        $tickets = Price::where('type', 'ticket')->where('is_active', true)->get();
        $rentals = Price::where('type', 'rental')->where('is_active', true)->get();
        return view('public.pricing', compact('tickets', 'rentals'));
    }

    // /announcements
    public function announcements(Request $request)
    {
        $type  = $request->query('type', 'all');
        $query = Announcement::where('is_active', true);
        if (in_array($type, ['event', 'promo', 'info'])) {
            $query->where('type', $type);
        }
        $announcements = $query->latest()->paginate(9);
        return view('public.announcements.index', compact('announcements', 'type'));
    }

    // /announcements/{slug}
    public function announcementShow($slug)
    {
        $announcement = Announcement::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        $announcement->increment('views');
        $related = Announcement::where('is_active', true)
            ->where('id', '!=', $announcement->id)
            ->where('type', $announcement->type)
            ->latest()
            ->take(3)
            ->get();
        return view('public.announcements.show', compact('announcement', 'related'));
    }

    // /schedule
    public function schedule()
    {
        $schedules = Schedule::where('is_active', true)->get();
        return view('public.schedule', compact('schedules'));
    }

    // /faq
    public function faq()
    {
        $faqs = Faq::where('is_active', true)->orderBy('order')->get();
        return view('public.faq', compact('faqs'));
    }

    // /contact
    public function contact()
    {
        $contact = Contact::where('is_active', true)->first();
        return view('public.contact', compact('contact'));
    }

    // /reviews
    public function reviews(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Silakan login terlebih dahulu untuk memberikan ulasan.');
        }

        $reviews       = Review::with('user')->latest()->paginate(9);
        $averageRating = round(Review::avg('rating') ?? 0, 1); // sesuai nama di blade
        $total         = Review::count();                       // sesuai nama di blade
        $userReview    = Review::where('user_id', Auth::id())->first();

        return view('public.reviews.index', compact('reviews', 'averageRating', 'total', 'userReview'));
    }

    // POST /reviews
    public function reviewStore(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'rating' => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        try {
            $existing = Review::where('user_id', Auth::id())->first();

            if ($existing) {
                $existing->update([
                    'rating'  => $request->rating,
                    'comment' => $request->comment,
                ]);
                $message = 'Ulasan kamu berhasil diperbarui!';
            } else {
                Review::create([
                    'user_id' => Auth::id(),
                    'rating'  => $request->rating,
                    'comment' => $request->comment,
                ]);
                $message = 'Terima kasih! Ulasan kamu berhasil ditambahkan.';
            }

            return redirect()->route('public.reviews')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('PublicController::reviewStore failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan ulasan. Silakan coba lagi.');
        }
    }
}
