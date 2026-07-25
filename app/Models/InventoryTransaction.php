<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventoriable_type',
        'inventoriable_id',
        'type',
        'direction',
        'quantity',
        'previous_quantity',
        'current_quantity',
        'unit_price',
        'total_price',
        'user_id',
        'purchase_request_id',
        'appointment_id',
        'description',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'previous_quantity' => 'integer',
        'current_quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    // ================ Relationships ================

    public function inventoriable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // ================ Scopes ================

    public function scopeIn($query)
    {
        return $query->where('direction', 'in');
    }

    public function scopeOut($query)
    {
        return $query->where('direction', 'out');
    }

    public function scopePurchase($query)
    {
        return $query->where('type', 'purchase');
    }

    public function scopeUsage($query)
    {
        return $query->where('type', 'usage');
    }
}