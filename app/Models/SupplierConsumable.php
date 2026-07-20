<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierConsumable extends Model
{
    use HasFactory;

    protected $table = 'supplier_consumable';

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }
}