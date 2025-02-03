<?php

namespace App\Http\Controllers;

use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    // Obtener productos más vendidos
    public function getTopSellingProducts(Request $request): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $limit = $request->input('limit', 20);

        $topProducts = $this->saleService->getTopSellingProducts($startDate, $endDate, $limit);

        return response()->json($topProducts);
    }

    // Obtener ventas por rango de tiempo (diarias, semanales, mensuales)
    public function getSalesByTimeRange(Request $request): JsonResponse
    {
        $range = $request->input('range'); // 'daily', 'weekly', 'monthly'
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!in_array($range, ['daily', 'weekly', 'monthly'])) {
            return response()->json(['error' => 'Rango inválido'], 400);
        }

        $sales = $this->saleService->getSalesByTimeRange($range, $startDate, $endDate);

        return response()->json($sales);
    }
}
