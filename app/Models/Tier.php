<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'description',
        'min_points',
        'max_points',
        'discount_percentage',
        'referral_bonus_percentage',
        'min_visits',
        'min_referrals',
        'min_total_purchase',
        'is_vip',
        'is_active',
    ];

    protected $casts = [
        'min_points' => 'integer',
        'max_points' => 'integer',
        'discount_percentage' => 'decimal:2',
        'referral_bonus_percentage' => 'decimal:2',
        'min_visits' => 'integer',
        'min_referrals' => 'integer',
        'min_total_purchase' => 'decimal:2',
        'is_vip' => 'boolean',
        'is_active' => 'boolean',
    ];

    // ================ Relationships ================

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // ================ Scopes ================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVip($query)
    {
        return $query->where('is_vip', true);
    }
}