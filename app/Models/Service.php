<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'seo_content',
        'article_content',
        'price',
        'duration_minutes',
        'is_active',
        'review_count',
    ];

    protected $casts = [
        'price' => 'integer',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
        'review_count' => 'integer',
    ];

    // ================ Relationships ================

    // Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // User Services (تخصص پرسنل)
    public function userServices()
    {
        return $this->hasMany(UserService::class);
    }

    public function staff()
    {
        return $this->belongsToMany(User::class, 'user_service');
    }

    // ================ Scopes ================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}