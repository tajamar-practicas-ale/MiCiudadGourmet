<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        return response()->json(['success' => true, 'data' => Category::all()]);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);

        try {
            $category = Category::create($data);
            return response()->json(['success' => true, 'data' => $category], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear categoría'], 500);
        }
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id . '|max:255',
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update($data);

            return response()->json(['success' => true, 'data' => $category]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar categoría'], 500);
        }
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['success' => true, 'message' => 'Categoría eliminada']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar categoría'], 500);
        }
    }
}
