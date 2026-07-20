<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevicePart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'part_number',
        'device_id',
        'brand_id',
        'max_shots',
        'used_shots',
        'installation_date',
        'replacement_date',
        'notes',
    ];

    protected $casts = [
        'max_shots' => 'integer',
        'used_shots' => 'integer',
        'installation_date' => 'date',
        'replacement_date' => 'date',
    ];

    // ================ Relationships ================

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Supplier (تامین‌کننده اصلی - 1 به چند)
    public function primarySupplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    // Suppliers (تامین‌کنندگان - چندبه‌چند)
    public function suppliers()
    {
        return $this->belongsToMany(User::class, 'supplier_device_part', 'device_part_id', 'supplier_id')
            ->withPivot('price', 'is_primary')
            ->withTimestamps();
    }
}