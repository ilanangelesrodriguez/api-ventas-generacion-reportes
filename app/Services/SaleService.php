<?php


namespace App\Services;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Repositories\SaleRepository;
use App\Repositories\ProductRepository;
use Exception;

class SaleService
{
    protected SaleRepository $saleRepository;
    protected ProductRepository $productRepository;

    public function __construct(SaleRepository $saleRepository, ProductRepository $productRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
    }

    public function createSale(array $data)
    {
        // Validar stock de productos
        foreach ($data['products'] as $item) {
            $product = $this->productRepository->findById($item['product_id']);
            if ($product->stock < $item['quantity']) {
                throw new Exception("No hay suficiente stock para el producto {$product->name}");
            }
        }

        // Crear la venta
        $sale = $this->saleRepository->create($data);

        // Actualizar stock de productos
        foreach ($data['products'] as $item) {
            $this->productRepository->decreaseStock($item['product_id'], $item['quantity']);
        }

        return $sale;
    }

    public function getSaleDetails(int $id)
    {
        return $this->saleRepository->getDetails($id);
    }

    // Productos Más Vendidos
    public function getTopSellingProducts($startDate, $endDate, $limit = 20)
    {
        return SaleDetail::selectRaw('product_id, SUM(quantity) as total_sold, SUM(total_price) as total_revenue')
            ->with('product')
            ->whereHas('sale', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('sale_date', [$startDate, $endDate]);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    // Ventas Diarias, Semanales y Mensuales
    public function getSalesByTimeRange($range, $startDate, $endDate)
    {
        return Sale::whereBetween('sale_date', [$startDate, $endDate])
            ->when($range === 'daily', function ($query) {
                $query->selectRaw('DATE(sale_date) as date, COUNT(*) as total_sales, SUM(total_amount) as total_revenue')
                    ->groupBy('date');
            })
            ->when($range === 'weekly', function ($query) {
                $query->selectRaw('YEARWEEK(sale_date) as week, COUNT(*) as total_sales, SUM(total_amount) as total_revenue')
                    ->groupBy('week');
            })
            ->when($range === 'monthly', function ($query) {
                $query->selectRaw('YEAR(sale_date) as year, MONTH(sale_date) as month, COUNT(*) as total_sales, SUM(total_amount) as total_revenue')
                    ->groupBy('year', 'month');
            })
            ->get();
    }
}
