<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

// Form Requests
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;

class RestaurantController extends Controller
{
    // GET /api/restaurants
    public function index()
    {
        // Cargar restaurantes con relaciones para evitar N+1
        $restaurants = Restaurant::with(['user', 'categories', 'photos', 'reviews'])->get();

        return response()->json(['success' => true, 'data' => $restaurants]);
    }

    // POST /api/restaurants
    public function store(StoreRestaurantRequest $request)
    {
        // 1. Validar datos de entrada
        $data = $request->validated();

        try {
            // 2. Crear restaurante vinculado al usuario autenticado
            $restaurant = Auth::user()->restaurants()->create($data);

            // 3. Asociar categorías si vienen incluidas
            if (isset($data['category_ids'])) {
                $restaurant->categories()->sync($data['category_ids']);
            }

            // 4. Devolver respuesta JSON
            return response()->json(['success' => true, 'data' => $restaurant], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear restaurante'], 500);
        }
    }

    // GET /api/restaurants/{id}
    public function show($id)
    {
        try {
            $restaurant = Restaurant::with(['user', 'categories', 'photos', 'reviews'])->findOrFail($id);
            return response()->json(['success' => true, 'data' => $restaurant]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Restaurante no encontrado'], 404);
        }
    }

    // PUT /api/restaurants/{id}
    public function update(UpdateRestaurantRequest $request, $id)
    {
	$data = $request->validated();

        try {
            $restaurant = Restaurant::findOrFail($id);

            // Comprobación de permisos
            if (Auth::id() !== $restaurant->user_id) {
                return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
            }

            $restaurant->update($data);

            if (isset($data['category_ids'])) {
                $restaurant->categories()->sync($data['category_ids']);
            }

            return response()->json(['success' => true, 'data' => $restaurant]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Restaurante no encontrado'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar restaurante'], 500);
        }
    }

    // DELETE /api/restaurants/{id}
    public function destroy($id)
    {
        try {
            $restaurant = Restaurant::findOrFail($id);

            if (Auth::id() !== $restaurant->user_id) {
                return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
            }

            $restaurant->delete();
            return response()->json(['success' => true, 'message' => 'Restaurante eliminado']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Restaurante no encontrado'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar restaurante'], 500);
        }
    }
}

// En routes/api.php, define rutas así:
// Route::apiResource('restaurants', App\Http\Controllers\Api\RestaurantController::class);

// Para autenticación:
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function() {
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::apiResource('restaurants', RestaurantController::class);
// });
