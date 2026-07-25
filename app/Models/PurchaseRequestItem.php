<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_request_id',
        'purchasable_type',
        'purchasable_id',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
        'received_quantity',
        'received_notes',
    ];


    // ================ Relationships ================

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

}