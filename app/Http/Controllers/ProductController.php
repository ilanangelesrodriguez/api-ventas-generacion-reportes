<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Listar productos
    public function index(): JsonResponse
    {
        return response()->json($this->productService->getAllProducts());
    }

    // Crear un producto
    public function store(ProductRequest $request): JsonResponse
    {
        return response()->json($this->productService->createProduct($request->validated()), 201);
    }

    // Mostrar un producto
    public function show(int $id): JsonResponse
    {
        return response()->json($this->productService->getProductById($id));
    }

    // Actualizar un producto
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        return response()->json($this->productService->updateProduct($id, $request->validated()));
    }

    // Eliminar un producto
    public function destroy(int $id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
