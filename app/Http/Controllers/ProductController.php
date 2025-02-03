<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

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
        try {
            return response()->json($this->productService->getAllProducts());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al listar productos', 'message' => $e->getMessage()], 500);
        }
    }

    // Crear un producto
    public function store(ProductRequest $request): JsonResponse
    {
        try {
            return response()->json($this->productService->createProduct($request->validated()), 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Error de validación', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear producto', 'message' => $e->getMessage()], 500);
        }
    }

    // Mostrar un producto
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->productService->getProductById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Producto no encontrado', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al mostrar producto', 'message' => $e->getMessage()], 500);
        }
    }

    // Actualizar un producto
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            return response()->json($this->productService->updateProduct($id, $request->validated()));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Producto no encontrado', 'message' => $e->getMessage()], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Error de validación', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar producto', 'message' => $e->getMessage()], 500);
        }
    }

    // Eliminar un producto
    public function destroy(int $id): JsonResponse
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }
        try {
            $this->productService->deleteProduct($id);
            return response()->json(['message' => 'Producto eliminado correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Producto no encontrado', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar producto', 'message' => $e->getMessage()], 500);
        }
    }
}
