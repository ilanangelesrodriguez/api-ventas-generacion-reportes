<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Jobs\SendSaleSummaryEmail;
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
            // Lógica para registrar la venta
            $sale = $this->saleService->createSale($request->all());

            // Datos para el correo
            $customerEmail = $sale->customer->email;
            $saleDetails = [
                'products' => $sale->details->map(function ($detail) {
                    return [
                        'name' => $detail->product->name,
                        'quantity' => $detail->quantity,
                        'price' => $detail->unit_price,
                    ];
                })->toArray(),
                'total_amount' => $sale->total_amount,
            ];

            // Despacha el job para enviar el correo
            SendSaleSummaryEmail::dispatch($customerEmail, $saleDetails);

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
