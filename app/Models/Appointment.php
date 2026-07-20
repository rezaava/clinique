<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'service_id',
        'assigned_staff_id',
        'appointment_date',
        'appointment_time',
        'duration_minutes',
        'status',
        'client_notes',
        'staff_notes',
        'amount',
        'payment_status',
        'deposit_amount',
        'paid_at',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
        'cancel_reason',
        'rating',
        'staff_rating',
        'review',
        'reviewed_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
        'duration_minutes' => 'integer',
        'amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'rating' => 'integer',
        'staff_rating' => 'integer',
    ];

    // ================ Relationships ================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // ================ Scopes ================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', now()->toDateString());
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed']);
    }
}