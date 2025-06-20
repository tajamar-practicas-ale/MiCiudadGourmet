<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Photo;

class FavoriteController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        $request->user()->favorites()->attach($restaurantId);
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, $restaurantId)
    {
        $request->user()->favorites()->detach($restaurantId);
        return response()->json(['success' => true]);
    }
}

