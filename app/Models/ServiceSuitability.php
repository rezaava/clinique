<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSuitability extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'text',
        'level',
    ];

    protected $casts = [
        'service_id' => 'integer',
        'level' => 'integer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}