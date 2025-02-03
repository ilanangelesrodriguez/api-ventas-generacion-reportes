<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesByTimeRangeExport implements FromCollection, WithHeadings
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    // Define los encabezados del archivo Excel
    public function headings(): array
    {
        return [
            'Fecha',
            'Total de Ventas',
            'Ingresos Totales',
        ];
    }

    // Define los datos que se exportarán
    public function collection(): Collection
    {
        return collect($this->sales)->map(function ($sale) {
            return [
                'date' => $sale['date'] ?? $sale['week'] ?? $sale['month'] . '/' . $sale['year'],
                'total_sales' => $sale['total_sales'],
                'total_revenue' => $sale['total_revenue'],
            ];
        });
    }
}
