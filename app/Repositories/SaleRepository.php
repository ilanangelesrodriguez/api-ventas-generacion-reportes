<?php


namespace App\Repositories;

use App\Models\Sale;
use App\Models\SaleDetail;

class SaleRepository
{
    public function create(array $data)
    {
        $sale = Sale::create([
            'code' => $data['code'],
            'customer_name' => $data['customer_name'],
            'customer_identification' => $data['customer_identification'],
            'customer_email' => $data['customer_email'],
            'seller_id' => $data['seller_id'],
            'total_amount' => $data['total_amount'],
            'sale_date' => now(),
        ]);

        foreach ($data['products'] as $item) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return $sale;
    }

    public function getDetails(int $id)
    {
        return Sale::with('saleDetails.product')->findOrFail($id);
    }
}
