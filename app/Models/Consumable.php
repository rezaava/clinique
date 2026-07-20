<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'brand_id',
        'stock_quantity',
        'minimum_stock',
        'unit_price',
        'unit',
        'expiry_date',
        'notes',
        'supplier_id',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer',
        'unit_price' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    // ================ Relationships ================

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    // ================ Scopes ================

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'minimum_stock');
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }
}