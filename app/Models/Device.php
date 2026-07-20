<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'model',
        'serial_number',
        'brand_id',
        'purchase_date',
        'purchase_price',
        'warranty_months',
        'total_shots_limit',
        'used_shots',
        'last_maintenance_date',
        'notes',
        'status',
        'supplier_id',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'warranty_months' => 'integer',
        'total_shots_limit' => 'integer',
        'used_shots' => 'integer',
        'last_maintenance_date' => 'date',
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

    public function deviceParts()
    {
        return $this->hasMany(DevicePart::class);
    }

    public function shiftReports()
    {
        return $this->hasMany(ShiftReport::class);
    }

    // ================ Scopes ================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }
}