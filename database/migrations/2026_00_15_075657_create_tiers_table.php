<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->id();
            
            // اطلاعات پایه سطح
            $table->string('name', 50); // عادی، وفادار، طلایی، الماس، ...
            $table->string('slug', 50)->unique(); // normal, loyal, golden, diamond, ...
            $table->string('icon')->nullable(); // آیکون سطح
            $table->string('color', 20)->default('#6c757d'); // رنگ برای نمایش
            $table->text('description')->nullable(); // توضیحات سطح
            
            // شرایط و امتیازات
            $table->integer('min_points')->default(0); // حداقل امتیاز برای این سطح
            $table->integer('max_points')->nullable(); // حداکثر امتیاز (نال یعنی بی‌نهایت)
            
            // تخفیفات و مزایا
            $table->decimal('discount_percentage', 5, 2)->default(0); // درصد تخفیف پایه
            $table->decimal('referral_bonus_percentage', 5, 2)->default(0); // درصد پاداش معرفی
            
            // شرایط خاص
            $table->integer('min_visits')->default(0); // حداقل تعداد مراجعه
            $table->integer('min_referrals')->default(0); // حداقل تعداد معرفی
            $table->decimal('min_total_purchase', 15, 2)->default(0); // حداقل مبلغ خرید کل
            
            // سطوح ویژه
            $table->boolean('is_vip')->default(false); // سطح ویژه
            $table->boolean('is_active')->default(true); // فعال/غیرفعال
                                    
            $table->timestamps();
            
            // ایندکس‌ها
            $table->index(['min_points', 'max_points']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers');
    }
};