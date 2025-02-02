<?php


namespace App\Services;

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
}
