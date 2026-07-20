<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // کلاینت
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_staff_id')->nullable()->constrained('users')->nullOnDelete(); // پرسنل انجام‌دهنده

            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('duration_minutes')->default(30);

            $table->enum('status', [
                'pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'
            ])->default('pending');

            $table->text('client_notes')->nullable();
            $table->text('staff_notes')->nullable();

            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->decimal('deposit_amount', 15, 2)->default(0);
            $table->timestamp('paid_at')->nullable();

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();

            // امتیاز و نظر کلاینت
            $table->tinyInteger('rating')->unsigned()->nullable(); // به خدمت
            $table->tinyInteger('staff_rating')->unsigned()->nullable(); // به پرسنل
            $table->text('review')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'appointment_date']);
            $table->index(['service_id', 'appointment_date']);
            $table->index('status');
            $table->index('assigned_staff_id');
            $table->index(['appointment_date', 'appointment_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};