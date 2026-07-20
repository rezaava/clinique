<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements LaratrustUser
{
    use HasRolesAndPermissions;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'national_code',
        'password',
        'birth_date',
        'gender',
        'avatar',
        'address',
        'postal_code',
        'status',
        'last_login_at',
        'referral_code',
        'referred_by',
        'skin_info',
        'hair_info',
        'health_info',
        'medical_notes',
        'source',
        'tags',
        'points',
        'tier_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_login_at' => 'datetime',
        'skin_info' => 'array',
        'hair_info' => 'array',
        'health_info' => 'array',
        'tags' => 'array',
        'points' => 'integer',
    ];

    // ================ Relationships ================

    // Self-referencing for referrals (خودارتباطی برای معرفی)
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    // Tier (سطح کاربری)
    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }

    // Appointments (نوبت‌ها)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function assignedAppointments()
    {
        return $this->hasMany(Appointment::class, 'assigned_staff_id');
    }

    // Consultations (مشاوره‌ها)
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }

    public function assignedConsultations()
    {
        return $this->hasMany(Consultation::class, 'assigned_to');
    }

    // Feedback (نظرات و انتقادات)
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function respondedFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'responded_by');
    }

    // Discounts (کدهای تخفیف)
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'created_by');
    }

    // User Tags (تگ‌های کاربر)
    public function userTags()
    {
        return $this->hasMany(UserTag::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tags');
    }

    // User Services (تخصص پرسنل)
    public function userServices()
    {
        return $this->hasMany(UserService::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_service');
    }

    // ================ Supplier Relationships (Many-to-Many) ================
    
    // Devices (دستگاه‌ها - به عنوان تأمین‌کننده چندبه‌چند)
    public function suppliedDevices()
    {
        return $this->belongsToMany(Device::class, 'supplier_device', 'supplier_id', 'device_id')
            ->withPivot('price', 'warranty_months', 'is_primary')
            ->withTimestamps();
    }

    // Device Parts (قطعات - به عنوان تأمین‌کننده چندبه‌چند)
    public function suppliedDeviceParts()
    {
        return $this->belongsToMany(DevicePart::class, 'supplier_device_part', 'supplier_id', 'device_part_id')
            ->withPivot('price', 'is_primary')
            ->withTimestamps();
    }

    // Consumables (مواد مصرفی - به عنوان تأمین‌کننده چندبه‌چند)
    public function suppliedConsumables()
    {
        return $this->belongsToMany(Consumable::class, 'supplier_consumable', 'supplier_id', 'consumable_id')
            ->withPivot('price', 'is_primary')
            ->withTimestamps();
    }

    // Shift Reports (گزارش شیفت)
    public function shiftReports()
    {
        return $this->hasMany(ShiftReport::class, 'user_id');
    }

    public function verifiedShiftReports()
    {
        return $this->hasMany(ShiftReport::class, 'verified_by');
    }

    // User Points (امتیازات)
    public function userPoints()
    {
        return $this->hasMany(UserPoint::class);
    }

    // User Referrals (معرفی‌ها)
    public function referrer()
    {
        return $this->hasMany(UserReferral::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->hasMany(UserReferral::class, 'referred_id');
    }

    // Transactions (تراکنش‌ها)
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function createdTransactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    // Sms Logs
    public function smsLogs()
    {
        return $this->hasMany(SmsLog::class);
    }

    // Campaigns
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    // ================ Helper Methods ================

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isStaff(): bool
    {
        return $this->hasRole(['admin', 'doctor', 'operator', 'receptionist']);
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function isSupplier(): bool
    {
        return $this->hasRole('supplier');
    }
}