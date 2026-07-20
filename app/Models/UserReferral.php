<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code',
        'status',
        'registered_at',
        'first_purchase_at',
        'commission_points',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'first_purchase_at' => 'datetime',
        'commission_points' => 'integer',
    ];

    // ================ Relationships ================

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }
}