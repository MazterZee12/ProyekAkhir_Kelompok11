<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    // Halaman semua review
    public function index()
    {
        $reviews       = Review::with('user')->visible()->orderByDesc('created_at')->paginate(12);
        $averageRating = round(Review::avg('rating'), 1);
        $total         = Review::visible()->count();
        return view('public.reviews.index', compact('reviews', 'averageRating', 'total'));
    }

    // Form tulis review
    public function create()
    {
        $userReview = Review::where('user_id', Auth::id())->first();
        return view('public.reviews.create', compact('userReview'));
    }

    // Simpan review
    public function store(Request $request)
    {
        $request->validate([
            'rating'  => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required'  => 'Rating wajib dipilih.',
            'rating.in'        => 'Rating tidak valid.',
            'comment.required' => 'Komentar wajib diisi.',
            'comment.min'      => 'Komentar minimal 10 karakter.',
            'comment.max'      => 'Komentar maksimal 1000 karakter.',
        ]);

        try {
            Review::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'rating'  => $request->rating,
                    'comment' => $request->comment,
                ]
            );

            return redirect()->route('reviews.index')
                ->with('success', 'Ulasan kamu berhasil disimpan, terima kasih!');
        } catch (\Exception $e) {
            Log::error('Public\ReviewController::store failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan ulasan. Silakan coba lagi.');
        }
    }

    // Laporkan review — dengan alasan
    public function report(Request $request, Review $review)
    {
        if ($review->user_id === Auth::id()) {
            return back()->with('error', 'Kamu tidak bisa melaporkan ulasanmu sendiri.');
        }

        if (Auth::user()->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat melaporkan ulasan.');
        }

        $request->validate([
            'reason' => 'required|in:spam,kata_kasar,tidak_relevan,lainnya',
            'note'   => 'nullable|string|max:255',
        ]);

        // Jika lainnya dan ada note, simpan teks aslinya
        $reasonLabels = [
            'spam'          => 'Spam',
            'kata_kasar'    => 'Kata Kasar',
            'tidak_relevan' => 'Tidak Relevan',
            'lainnya'       => 'Lainnya' . ($request->filled('note') ? ': ' . $request->note : ''),
        ];

        try {
            $review->addReport($reasonLabels[$request->reason]);

            $message = $review->is_hidden
                ? 'Ulasan telah disembunyikan karena banyak laporan.'
                : 'Ulasan berhasil dilaporkan.';

            return back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Public\ReviewController::report failed', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal mengirim laporan.');
        }
    }
}
