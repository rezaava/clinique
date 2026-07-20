<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'message_template',
        'start_date',
        'end_date',
        'notification_days_before',
        'target_tags',
        'target_tiers',
        'is_active',
        'is_automatic',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'notification_days_before' => 'integer',
        'target_tags' => 'array',
        'target_tiers' => 'array',
        'is_active' => 'boolean',
        'is_automatic' => 'boolean',
    ];

    // ================ Relationships ================

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function smsLogs()
    {
        return $this->hasMany(SmsLog::class);
    }

    // ================ Scopes ================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAutomatic($query)
    {
        return $query->where('is_automatic', true);
    }
}