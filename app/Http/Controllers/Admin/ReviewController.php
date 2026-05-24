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
            if ($request->status === 'trashed') {
                $query->onlyTrashed();
            } elseif ($request->status === 'hidden') {
                $query->where('is_hidden', true);
            } elseif ($request->status === 'reported') {
                $query->where('reports_count', '>', 0);
            }
        }

        $reviews        = $query->paginate(20);
        $reportedCount  = Review::where('reports_count', '>', 0)->where('is_hidden', false)->count();

        return view('admin.reviews.index', compact('reviews', 'reportedCount'));
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
                ->with('success', 'Review dihapus.');
        } catch (\Exception $e) {
            Log::error('ReviewController::destroy failed', [
                'id'    => $review->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->route('admin.reviews.index')
                ->with('error', 'Gagal menghapus review.');
        }
    }

    public function restore($id)
    {
        try {
            $review = Review::withTrashed()->findOrFail($id);
            $review->restore();
            return redirect()
                ->route('admin.reviews.index')
                ->with('success', 'Review dipulihkan.');
        } catch (\Exception $e) {
            Log::error('ReviewController::restore failed', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->route('admin.reviews.index')
                ->with('error', 'Gagal memulihkan review.');
        }
    }

    // Tampilkan kembali review yang disembunyikan
    public function unhide(Review $review)
    {
        try {
            $review->is_hidden      = false;
            $review->reports_count  = 0;
            $review->report_reasons = null;
            $review->save();

            return back()->with('success', 'Review ditampilkan kembali.');
        } catch (\Exception $e) {
            Log::error('ReviewController::unhide failed', [
                'id'    => $review->id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal menampilkan review.');
        }
    }
}
