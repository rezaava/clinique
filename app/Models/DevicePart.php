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
        'supplier_id',
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

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
}