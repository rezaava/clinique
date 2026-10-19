<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'service_id',
        'name',
        'phone',
        'type',
        'description',
        'photo_path',
        'notes',
        'assigned_to',
        'doctor_working_time_slot_id',
        'consultation_date',
        'any_time',
        'price',
        'status',
        'assigned_at',
        'result',
        'recommendations',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'any_time' => 'boolean',
        'price' => 'decimal:2',
        'assigned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function doctorWorkingTimeSlot()
    {
        return $this->belongsTo(
            WorkingTimeSlot::class,
            'doctor_working_time_slot_id'
        );
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}