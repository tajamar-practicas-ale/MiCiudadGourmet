<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

// Form Requests
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        return response()->json(['success' => true, 'data' => Category::all()]);
    }

    // POST /api/categories
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        try {
            $category = Category::create($data);
            return response()->json(['success' => true, 'data' => $category], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear categoría'], 500);
        }
    }

    // PUT /api/categories/{id}
    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->validated();

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
