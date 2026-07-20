<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // پرسنل
            $table->date('shift_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('shots_used')->default(0); // شات مصرف شده در این شیفت
            $table->json('consumables_used')->nullable(); // مواد مصرفی استفاده شده
            $table->text('notes')->nullable();
            $table->boolean('is_received')->default(false); // آیا شیفت تحویل گرفته شده
            $table->timestamp('received_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete(); // تاییدکننده (مدیر/منشی)
            $table->timestamps();

            $table->index(['user_id', 'shift_date']);
            $table->index('device_id');
            $table->index('is_received');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_reports');
    }
};