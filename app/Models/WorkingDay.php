<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = [
        'name_fa',
        'name_en',
        'day',
    ];

    protected $casts = [
        'day' => 'integer',
    ];
    public function workingTimeSlots()
    {
        return $this->hasMany(WorkingTimeSlot::class);
    }
}