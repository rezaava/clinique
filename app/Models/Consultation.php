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
        'type',
        'preferred_date',
        'preferred_time',
        'description',
        'status',
        'assigned_to',
        'assigned_at',
        'result',
        'recommendations',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime',
        'assigned_at' => 'datetime',
    ];

    // ================ Relationships ================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}