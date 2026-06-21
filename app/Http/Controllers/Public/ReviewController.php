<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')
            ->visible()
            ->orderByDesc('created_at')
            ->paginate(12);

        $averageRating = round(Review::visible()->avg('rating'), 1);
        $total = Review::visible()->count();

        return view('public.reviews.index', compact('reviews', 'averageRating', 'total'));
    }

    public function create()
    {
        $userReviews = Review::where('user_id', Auth::id())
            ->orderByDesc('visit_date')
            ->get();

        return view('public.reviews.create', compact('userReviews'));
    }

    public function edit(Review $review)
    {
        abort_unless($review->user_id === Auth::id(), 403);

        if (! $review->isEditable()) {
            return redirect()->route('reviews.index')
                ->with('error', 'Ulasan ini sudah tidak bisa diubah (lebih dari 7 hari sejak dibuat).');
        }

        return view('public.reviews.edit', compact('review'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visit_date' => 'required|date|before_or_equal:today',
            'rating'     => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'comment'    => 'required|string|min:10|max:1000',
        ], [
            'visit_date.required'        => 'Tanggal kunjungan wajib diisi.',
            'visit_date.before_or_equal' => 'Tanggal kunjungan tidak boleh di masa depan.',
            'rating.required'            => 'Rating wajib dipilih.',
            'rating.in'                  => 'Rating tidak valid.',
            'comment.required'           => 'Komentar wajib diisi.',
            'comment.min'                => 'Komentar minimal 10 karakter.',
            'comment.max'                => 'Komentar maksimal 1000 karakter.',
        ]);

        $existing = Review::where('user_id', Auth::id())
            ->whereDate('visit_date', $request->visit_date)
            ->first();

        if ($existing) {
            if (! $existing->isEditable()) {
                return back()->withInput()->with(
                    'error',
                    'Kamu sudah mengulas tanggal kunjungan ini dan ulasan tersebut sudah tidak bisa diubah lagi (lebih dari 7 hari).'
                );
            }

            return redirect()->route('reviews.edit', $existing)
                ->with('info', 'Kamu sudah mengulas tanggal ini sebelumnya — silakan perbarui ulasanmu di bawah.');
        }

        try {
            Review::create([
                'user_id'    => Auth::id(),
                'visit_date' => $request->visit_date,
                'rating'     => $request->rating,
                'comment'    => $request->comment,
            ]);

            return redirect()
                ->route('reviews.index')
                ->with('success', 'Ulasan kamu berhasil disimpan, terima kasih!');
        } catch (\Exception $e) {
            Log::error('Public\\ReviewController::store failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Gagal menyimpan ulasan. Silakan coba lagi.');
        }
    }

    public function update(Request $request, Review $review)
    {
        abort_unless($review->user_id === Auth::id(), 403);

        if (! $review->isEditable()) {
            return back()->with('error', 'Ulasan ini sudah tidak bisa diubah (lebih dari 7 hari sejak dibuat).');
        }

        $request->validate([
            'visit_date' => 'required|date|before_or_equal:today',
            'rating'     => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'comment'    => 'required|string|min:10|max:1000',
        ], [
            'visit_date.required'        => 'Tanggal kunjungan wajib diisi.',
            'visit_date.before_or_equal' => 'Tanggal kunjungan tidak boleh di masa depan.',
            'rating.required'            => 'Rating wajib dipilih.',
            'rating.in'                  => 'Rating tidak valid.',
            'comment.required'           => 'Komentar wajib diisi.',
            'comment.min'                => 'Komentar minimal 10 karakter.',
            'comment.max'                => 'Komentar maksimal 1000 karakter.',
        ]);

        $conflict = Review::where('user_id', Auth::id())
            ->whereDate('visit_date', $request->visit_date)
            ->where('id', '!=', $review->id)
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'Kamu sudah memiliki ulasan untuk tanggal tersebut.');
        }

        try {
            $review->update([
                'visit_date' => $request->visit_date,
                'rating'     => $request->rating,
                'comment'    => $request->comment,
            ]);

            return redirect()
                ->route('reviews.index')
                ->with('success', 'Ulasan kamu berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Public\\ReviewController::update failed', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Gagal memperbarui ulasan. Silakan coba lagi.');
        }
    }

    public function destroy(Review $review)
    {
        abort_unless($review->user_id === Auth::id(), 403);

        if (! $review->isEditable()) {
            return back()->with('error', 'Ulasan ini sudah tidak bisa dihapus (lebih dari 7 hari sejak dibuat).');
        }

        try {
            $review->delete();

            return redirect()
                ->route('reviews.index')
                ->with('success', 'Ulasan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Public\\ReviewController::destroy failed', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal menghapus ulasan.');
        }
    }

    public function report(Request $request, Review $review)
    {
        if ($review->user_id === Auth::id()) {
            return back()->with('error', 'Kamu tidak bisa melaporkan ulasanmu sendiri.');
        }

        if (Auth::user()->isAdmin()) {
            return back()->with('error', 'Admin tidak dapat melaporkan ulasan.');
        }

        $request->validate([
            'reason' => 'required|in:spam,kata_kasar,tidak_relevan,lainnya',
            'note'   => 'nullable|string|max:255',
        ]);

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
        } catch (\RuntimeException $e) {
            // contoh: user sudah pernah melaporkan review ini
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Public\\ReviewController::report failed', [
                'review_id' => $review->id,
                'error'     => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengirim laporan.');
        }
    }
}
