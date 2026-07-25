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
    ];

    // ================ Relationships ================


    // Suppliers (چندبه‌چند)
    public function suppliers()
    {
        return $this->belongsToMany(User::class, 'supplier_consumable', 'consumable_id', 'supplier_id')
            ->withPivot('price', 'is_primary')
            ->withTimestamps();
    }

    // Primary Supplier
    public function primarySupplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    // Inventory Transactions
    public function inventoryTransactions()
    {
        return $this->morphMany(InventoryTransaction::class, 'inventoriable');
    }

    // Purchase Request Items
    public function purchaseRequestItems()
    {
        return $this->morphMany(PurchaseRequestItem::class, 'purchasable');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
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