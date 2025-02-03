<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear una venta inicial
        $sale = Sale::create([
            'code' => 'SALE001',
            'customer_name' => 'John Doe',
            'customer_identification' => 'DNI 12345678',
            'customer_email' => 'john.doe@example.com',
            'seller_id' => 2, // ID del vendedor
            'total_amount' => 2000.00,
            'sale_date' => now(),
        ]);

        // Detalles de la venta
        SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => 1, // ID del producto
            'quantity' => 2,
            'unit_price' => 1200.00,
            'total_price' => 2400.00,
        ]);
    }
}
