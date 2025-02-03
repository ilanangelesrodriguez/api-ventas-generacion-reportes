<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopSellingProductsExport implements FromCollection, WithHeadings
{
    protected $products;
    public function __construct($products)
    {
        $this->products = $products;
    }

    // Define los encabezados del archivo Excel
    public function headings(): array
    {
        return [
            'SKU',
            'Nombre',
            'Cantidad Vendida',
            'Monto Total',
        ];
    }

    // Define los datos que se exportarán
    public function collection(): Collection
    {
        return collect($this->products)->map(function ($product) {
            return [
                'sku' => $product['sku'],
                'name' => $product['name'],
                'total_sold' => $product['total_sold'],
                'total_revenue' => $product['total_revenue'],
            ];
        });
    }
}
