<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'service_id',
        'text',
        'answer',
    ];

    // رابطه FAQ با خدمت
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}