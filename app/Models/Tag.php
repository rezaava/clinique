<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // ================ Relationships ================

    public function userTags()
    {
        return $this->hasMany(UserTag::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tags');
    }

    // Campaigns (کمپین‌ها)
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_tag');
    }
}