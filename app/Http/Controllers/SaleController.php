<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    // Registrar una venta
    public function store(SaleRequest $request): JsonResponse
    {
        return response()->json($this->saleService->createSale($request->validated()), 201);
    }

    // Detalle de una venta
    public function show(int $id): JsonResponse
    {
        return response()->json($this->saleService->getSaleDetails($id));
    }
}
