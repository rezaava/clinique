<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // اطلاعات هویتی کاربر
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 20)->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->string('national_code', 10)->nullable()->unique();
            
            // اطلاعات ورود
            $table->string('password');
            $table->rememberToken();
            
            // اطلاعات شخصی
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('avatar')->nullable();
            
            // اطلاعات مکانی
            $table->text('address')->nullable();
            $table->string('postal_code', 10)->nullable();
            
            // وضعیت کاربر
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            
            // معرف و کد معرف
            $table->string('referral_code', 20)->unique()->nullable();
            $table->foreignId('referred_by')->nullable()->constrained('users')->nullOnDelete();
            
            // اطلاعات پزشکی و پوست (برای کلاینت‌ها)
            $table->string('skin_info')->nullable();
            $table->string('hair_info')->nullable();
            $table->string('health_info')->nullable();
            $table->text('medical_notes')->nullable();
            
            // اطلاعات مارکتینگ
            $table->string('source')->nullable();
            $table->string('tags')->nullable();
            
            // امتیازات و سطح - تغییر از tier به tier_id
            $table->integer('points')->default(0);
            $table->foreignId('tier_id')->nullable()->constrained('tiers')->nullOnDelete();            

            // تایم‌استمپ‌ها
            $table->timestamps();
            
            // ایندکس‌ها
            $table->index(['phone', 'email']);
            $table->index(['first_name', 'last_name']);
            $table->index('status');
            $table->index('referral_code');
            $table->index('referred_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};