<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Photo;

// Form Requests
use App\Http\Requests\StorePhotoRequest;

class PhotoController extends Controller
{
    public function store(StorePhotoRequest $request, $restaurantId)
    {
        $data = $request->validated();

        $photo = Photo::create([
            'restaurant_id' => $restaurantId,
            'url' => $data['url'],
        ]);

        return response()->json(['success' => true, 'data' => $photo], 201);
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->delete();

        return response()->json(['success' => true]);
    }
}
