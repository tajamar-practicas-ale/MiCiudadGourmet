<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Photo;

// Form Request
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
    
    use AuthorizesRequests;

    public function store(StoreReviewRequest $request, $restaurantId)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;
        $data['restaurant_id'] = $restaurantId;

        $review = Review::create($data);

        return response()->json(['success' => true, 'data' => $review], 201);
    }

    public function update(UpdateReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('update', $review);

        $data = $request->validated();

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
