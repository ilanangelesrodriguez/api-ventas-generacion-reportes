<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    // Registrar una venta
    public function store(SaleRequest $request): JsonResponse
    {
        try {
            return response()->json($this->saleService->createSale($request->validated()), 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Error de validación', 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la venta', 'message' => $e->getMessage()], 500);
        }
    }

    // Detalle de una venta
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->saleService->getSaleDetails($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Venta no encontrada', 'message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al mostrar la venta', 'message' => $e->getMessage()], 500);
        }
    }
}
