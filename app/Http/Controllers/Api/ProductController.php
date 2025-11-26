<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Lista todos los productos
     * GET /api/products
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $products = Product::with('categories')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return response()->json($products);
    }

    /**
     * Crear nuevo producto
     * POST /api/products
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id'
        ]);

        $product = Product::create($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        $product->load('categories');

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => $product
        ], 201);
    }

    /**
     * Mostrar un producto específico
     * GET /api/products/{id}
     */
    public function show(Product $product)
    {
        $product->load('categories');
        
        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Actualizar producto
     * PUT/PATCH /api/products/{id}
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id'
        ]);

        $product->update($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        $product->load('categories');

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'data' => $product
        ]);
    }

    /**
     * Eliminar producto
     * DELETE /api/products/{id}
     */
    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente'
        ], 200);
    }
}
