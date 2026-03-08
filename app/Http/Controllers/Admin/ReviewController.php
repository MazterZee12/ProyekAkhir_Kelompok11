<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

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

        $review->update($data);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted.');
    }

    public function restore($id)
    {
        $review = Review::withTrashed()->findOrFail($id);
        $review->restore();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review restored.');
    }

    public function toggleApproval(Review $review)
    {
        $review->approved = !$review->approved;
        $review->save();

        return back()->with('success', 'Review status updated.');
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
