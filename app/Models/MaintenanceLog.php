<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'performed_by',
        'type',
        'maintenance_date',
        'description',
        'parts_replaced',
        'notes',
        'cost',
        'next_maintenance_date',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'cost' => 'decimal:2',
        'next_maintenance_date' => 'date',
    ];

    // ================ Relationships ================

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    // ================ Scopes ================

    public function scopeRegular($query)
    {
        return $query->where('type', 'regular');
    }

    public function scopeEmergency($query)
    {
        return $query->where('type', 'emergency');
    }
}