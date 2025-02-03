<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::create([
            'sku' => 'SKU001',
            'name' => 'Laptop HP',
            'description' => 'Potente laptop para trabajo y juegos.',
            'unit_price' => 1200.00,
            'stock' => 50,
            'status' => 'active',
        ]);

        Product::create([
            'sku' => 'SKU002',
            'name' => 'Smartphone Samsung',
            'description' => 'Teléfono inteligente con cámara de alta resolución.',
            'unit_price' => 800.00,
            'stock' => 100,
            'status' => 'active',
        ]);
    }
}
