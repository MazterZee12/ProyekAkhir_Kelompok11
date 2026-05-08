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

        if ($request->filled('status') && $request->status === 'trashed') {
            $query->onlyTrashed();
        }

        $reviews = $query->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'rating'  => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'comment' => 'nullable|string',
        ]);

        try {
            $review->update($data);
            return redirect()
                ->route('admin.reviews.index')
                ->with('success', 'Review berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('ReviewController::update failed', [
                'id'    => $review->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui review.');
        }
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

    public function stats()
    {
        $total         = Review::count();
        $averageRating = round(Review::avg('rating'), 2);
        $breakdown     = [];
        for ($i = 5; $i >= 1; $i--) {
            $breakdown[$i] = Review::where('rating', $i)->count();
        }
        $trashed = Review::onlyTrashed()->count();

        return view('admin.reviews.stats', compact(
            'total',
            'averageRating',
            'breakdown',
            'trashed'
        ));
    }
}
