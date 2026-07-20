<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'appointment_id',
        'discount_id',
        'transaction_number',
        'type',
        'payment_method',
        'amount',
        'discount_amount',
        'final_amount',
        'status',
        'description',
        'reference_number',
        'meta_data',
        'paid_at',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'meta_data' => 'array',
    ];

    // ================ Relationships ================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ================ Scopes ================

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ================ Boot Methods ================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_number)) {
                $transaction->transaction_number = 'TRX-' . strtoupper(uniqid());
            }
        });
    }
}