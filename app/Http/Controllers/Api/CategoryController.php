<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Lista todas las categorías
     * GET /api/categories
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $categories = Category::withCount('products')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return response()->json($categories);
    }

    /**
     * Crear nueva categoría
     * POST /api/categories
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => $category
        ], 201);
    }

    /**
     * Mostrar una categoría específica
     * GET /api/categories/{id}
     */
    public function show(Category $category)
    {
        $category->loadCount('products');
        $category->load('products');
        
        return response()->json([
            'data' => $category
        ]);
    }

    /**
     * Actualizar categoría
     * PUT/PATCH /api/categories/{id}
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Categoría actualizada exitosamente',
            'data' => $category
        ]);
    }

    /**
     * Eliminar categoría
     * DELETE /api/categories/{id}
     */
    public function destroy(Category $category)
    {
        $category->products()->detach();
        $category->delete();

        return response()->json([
            'message' => 'Categoría eliminada exitosamente'
        ], 200);
    }
}
