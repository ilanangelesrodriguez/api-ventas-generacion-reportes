<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_name',
        'customer_identification',
        'customer_email',
        'seller_id',
        'total_amount',
        'sale_date',
    ];

    // Relación: Una venta pertenece a un vendedor (usuario)
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relación: Una venta puede tener muchos detalles de venta
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
}
