<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('discount_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // شماره تراکنش
            $table->string('transaction_number', 50)->unique();

            // نوع پرداخت
            $table->enum('type', [
                'payment',
                'refund'
            ])->default('payment');

            // روش پرداخت
            $table->enum('payment_method', [
                'cash',
                'card',
                'online',
                'other'
            ])->default('cash');

            // مبلغ اصلی نوبت
            $table->decimal('amount', 15, 2)->default(0);

            // تخفیف
            $table->decimal('discount_amount', 15, 2)->default(0);

            // مبلغ نهایی نوبت
            $table->decimal('final_amount', 15, 2)->default(0);

            // مبلغی که تا الان پرداخت شده
            $table->decimal('paid_amount', 15, 2)->default(0);

            // مبلغ باقی‌مانده
            $table->decimal('remaining_amount', 15, 2)->default(0);

            // وضعیت پرداخت
            $table->enum('status', [
                'unpaid',
                'partial',
                'paid',
                'refunded',
                'cancelled'
            ])->default('unpaid');

            $table->text('description')->nullable();

            // شماره مرجع پرداخت آنلاین/کارت
            $table->string('reference_number', 100)->nullable();

            // اطلاعات اضافی
            $table->json('meta_data')->nullable();

            // زمان آخرین پرداخت
            $table->timestamp('paid_at')->nullable();

            // ایجاد کننده تراکنش
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // جلوگیری از چند تراکنش برای یک نوبت
            $table->unique('appointment_id');

            $table->index(['user_id', 'status']);
            $table->index('transaction_number');
            $table->index('status');
            $table->index('paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};