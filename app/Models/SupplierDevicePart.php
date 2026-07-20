<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierDevicePart extends Model
{
    use HasFactory;

    protected $table = 'supplier_device_part';

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function devicePart()
    {
        return $this->belongsTo(DevicePart::class);
    }
}