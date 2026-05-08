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
        $reviews       = Review::with('user')->orderByDesc('created_at')->paginate(12);
        $averageRating = round(Review::avg('rating'), 1);
        $total         = Review::count();
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

    // Laporkan review
    public function report(Review $review)
    {
        if ($review->user_id === Auth::id()) {
            return back()->with('error', 'Kamu tidak bisa melaporkan ulasanmu sendiri.');
        }

        try {
            $review->increment('reports_count');
            return back()->with('success', 'Laporan berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Public\ReviewController::report failed', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal mengirim laporan. Silakan coba lagi.');
        }
    }

    // Hapus review milik sendiri
    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403);
        }

        try {
            $review->delete();
            return redirect()->route('reviews.index')
                ->with('success', 'Ulasan kamu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Public\ReviewController::destroy failed', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal menghapus ulasan. Silakan coba lagi.');
        }
    }
}
