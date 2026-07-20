<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'valid_from',
        'valid_to',
        'usage_limit',
        'used_count',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'valid_from' => 'date',
        'valid_to' => 'date',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
    ];

    // ================ Relationships ================

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ================ Scopes ================

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_to')
                    ->orWhere('valid_to', '>=', now());
            });
    }
}