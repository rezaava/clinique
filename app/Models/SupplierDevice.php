<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierDevice extends Model
{
    use HasFactory;

    protected $table = 'supplier_device';

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}