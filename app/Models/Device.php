<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;
    // ================ Relationships ================

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
        return $this->belongsToMany(User::class, 'supplier_device', 'device_id', 'supplier_id')
            ->withPivot('price', 'warranty_months', 'is_primary')
            ->withTimestamps();
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