<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ================ Relationships ================

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function deviceParts()
    {
        return $this->hasMany(DevicePart::class);
    }

    public function consumables()
    {
        return $this->hasMany(Consumable::class);
    }

    // ================ Scopes ================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}