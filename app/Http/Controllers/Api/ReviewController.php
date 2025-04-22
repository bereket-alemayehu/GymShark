<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ReviewResource::collection(Review::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string',
        ]);

        $existing = Review::where('product_id', $validated['product_id'])
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'You already submitted a review for this product.',
                'review' => new ReviewResource($existing)
            ], 200);
        }

        $review = Review::create([
            'product_id' => $validated['product_id'],
            'user_id'    => Auth::id(),
            'rating'     => $validated['rating'],
            'comment'    => $validated['comment'] ?? null,
            'status'     => 'pending',
        ]);

        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $review = Review::findOrFail($id);
        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $review = Review::findOrFail($id);

        // Only the owner can update
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update([
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'] ?? $review->comment,
        ]);

        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
