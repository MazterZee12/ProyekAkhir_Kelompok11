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
            match ($request->status) {
                'approved' => $query->approved(),
                'pending' => $query->pending(),
                'hidden' => $query->hidden(),
                'trashed' => $query->onlyTrashed(),
                default => null
            };
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
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'approved' => 'nullable|boolean',
        ]);

        $data['approved'] = $request->has('approved');

        try {
            $review->update($data);

            return redirect()
                ->route('admin.reviews.index')
                ->with('success', 'Review updated successfully.');

        } catch (\Exception $e) {
            Log::error('ReviewController::update failed', [
                'id'    => $review->id,
                'error' => $e->getMessage()
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
                ->with('success', 'Review deleted.');

        } catch (\Exception $e) {
            Log::error('ReviewController::destroy failed', [
                'id'    => $review->id,
                'error' => $e->getMessage()
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
                ->with('success', 'Review restored.');

        } catch (\Exception $e) {
            Log::error('ReviewController::restore failed', [
                'id'    => $id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.reviews.index')
                ->with('error', 'Gagal memulihkan review.');
        }
    }

    public function toggleApproval(Review $review)
    {
        try {
            $review->approved = !$review->approved;
            $review->save();

            return back()->with('success', 'Review status updated.');

        } catch (\Exception $e) {
            Log::error('ReviewController::toggleApproval failed', [
                'id'    => $review->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal memperbarui status review.');
        }
    }

    public function stats()
    {
        $baseQuery = Review::approved();

        $total = $baseQuery->count();
        $averageRating = round($baseQuery->avg('rating'), 2);
        $breakdown = [
            5 => (clone $baseQuery)->where('rating', 5)->count(),
            4 => (clone $baseQuery)->where('rating', 4)->count(),
            3 => (clone $baseQuery)->where('rating', 3)->count(),
            2 => (clone $baseQuery)->where('rating', 2)->count(),
            1 => (clone $baseQuery)->where('rating', 1)->count(),
        ];
        $pending = Review::pending()->count();
        $hidden = Review::hidden()->count();
        $trashed = Review::onlyTrashed()->count();

        return view('admin.reviews.stats', compact(
            'total',
            'averageRating',
            'breakdown',
            'pending',
            'hidden',
            'trashed'
        ));
    }
}
