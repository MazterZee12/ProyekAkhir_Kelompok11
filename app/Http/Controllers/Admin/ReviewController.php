<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            if ($request->status === 'hidden') {
                $query->where('is_hidden', true);
            } elseif ($request->status === 'visible') {
                $query->where('is_hidden', false);
            }
        }

        $reviews = $query->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function destroy(Review $review)
    {
        try {
            $review->delete();

            return redirect()
                ->route('admin.reviews.index')
                ->with('success', 'Review berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Admin\\ReviewController::destroy failed', [
                'id'    => $review->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.reviews.index')
                ->with('error', 'Gagal menghapus review.');
        }
    }

    public function toggleVisibility(Review $review)
    {
        try {
            $review->is_hidden = ! $review->is_hidden;
            $review->save();

            $message = $review->is_hidden
                ? 'Review disembunyikan.'
                : 'Review ditampilkan kembali.';

            return back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Admin\\ReviewController::toggleVisibility failed', [
                'id'    => $review->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengubah status review.');
        }
    }
}
