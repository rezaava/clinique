<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'points',
        'type',
        'source',
        'source_id',
        'description',
        'expires_at',
    ];

    protected $casts = [
        'points' => 'integer',
        'expires_at' => 'datetime',
    ];

    // ================ Relationships ================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relationship (اگر بخواهید)
    public function source()
    {
        return $this->morphTo();
    }

    // ================ Scopes ================

    public function scopeEarned($query)
    {
        return $query->where('type', 'earned');
    }

    public function scopeSpent($query)
    {
        return $query->where('type', 'spent');
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }
}