<?php

namespace App\Http\Controllers;

use App\Exports\SalesByTimeRangeExport;
use App\Exports\TopSellingProductsExport;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

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

        $cacheKey = "sales_by_time_range_{$range}_{$startDate}_{$endDate}";
        $sales = Cache::remember($cacheKey, 600, function () use ($range, $startDate, $endDate) {
            return $this->saleService->getSalesByTimeRange($range, $startDate, $endDate);
        });

        return response()->json($sales);
    }

    public function exportTopSellingProducts(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $limit = $request->input('limit', 20);

        // Obtener los datos de los productos más vendidos
        $topProducts = $this->saleService->getTopSellingProducts($startDate, $endDate, $limit);

        // Generar el archivo Excel
        return Excel::download(new TopSellingProductsExport($topProducts), 'top_selling_products.xlsx');
    }

    public function exportSalesByTimeRange(Request $request)
    {
        $range = $request->input('range'); // 'daily', 'weekly', 'monthly'
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!in_array($range, ['daily', 'weekly', 'monthly'])) {
            return response()->json(['error' => 'Rango inválido'], 400);
        }

        // Obtener los datos de las ventas agrupadas
        $sales = $this->saleService->getSalesByTimeRange($range, $startDate, $endDate);

        // Generar el archivo Excel
        return Excel::download(new SalesByTimeRangeExport($sales), 'sales_by_time_range.xlsx');
    }

}
