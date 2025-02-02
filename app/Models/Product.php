<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'unit_price',
        'stock',
        'status',
    ];

    // Relación: Un producto puede tener muchos detalles de venta
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class, 'product_id');
    }

    // Scope para filtrar productos activos
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
