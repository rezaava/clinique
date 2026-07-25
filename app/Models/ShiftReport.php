<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_number',
        'shift_date',
        'start_time',
        'end_time',
        'device_id',
        'shots_used',
        'consumables_used',
        'device_parts_used',
        'notes',
        'is_received',
        'received_at',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'shots_used' => 'integer',
        'consumables_used' => 'array',
        'device_parts_used' => 'array',
        'is_received' => 'boolean',
        'is_verified' => 'boolean',
        'received_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // ================ Relationships ================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ================ Scopes ================

    public function scopeReceived($query)
    {
        return $query->where('is_received', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeNotVerified($query)
    {
        return $query->where('is_verified', false);
    }
}