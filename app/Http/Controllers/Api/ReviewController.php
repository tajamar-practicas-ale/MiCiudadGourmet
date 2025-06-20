<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Photo;

class ReviewController extends Controller
{
    
    use AuthorizesRequests;

    public function store(Request $request, $restaurantId)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['restaurant_id'] = $restaurantId;

        $review = Review::create($data);

        return response()->json(['success' => true, 'data' => $review], 201);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('update', $review);

        $data = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($data);

        return response()->json(['success' => true, 'data' => $review]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('delete', $review);

        $review->delete();

        return response()->json(['success' => true]);
    }
}
