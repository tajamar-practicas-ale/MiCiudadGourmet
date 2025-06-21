<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Photo;

// Form Requests
use App\Http\Requests\StoreFavoriteRequest;

class FavoriteController extends Controller
{
    public function store(StoreFavoriteRequest $request, $restaurantId)
    {
	// Verificar que el restaurante existe
	Restaurant::findOrFail($restaurantId);

	// Asociar sin duplicar
        $request->user()->favorites()->syncWithoutDetaching([$restaurantId]);

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, $restaurantId)
    {
	// Verificar que el restaurante existe
        Restaurant::findOrFail($restaurantId);

	// Eliminar la relación
        $request->user()->favorites()->detach($restaurantId);

        return response()->json(['success' => true]);
    }
}

