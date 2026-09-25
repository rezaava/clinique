<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingTimeSlot extends Model
{
    protected $fillable = [
        'working_day_id',
        'start_time',
        'end_time',
    ];

    public function workingDay()
    {
        return $this->belongsTo(WorkingDay::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(User::class,'doctor_working_time_slot')->withTimestamps();
    }
}