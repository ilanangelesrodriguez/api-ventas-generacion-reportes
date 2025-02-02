<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identification',
        'email',
        'phone',
    ];

    // Relación: Un cliente puede tener muchas ventas
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }

    // Validaciones únicas
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->email = strtolower($model->email);
        });
    }
}
