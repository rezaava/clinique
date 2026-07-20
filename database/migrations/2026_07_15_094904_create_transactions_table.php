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
            
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('discount_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('transaction_number', 50)->unique();
            $table->enum('type', ['payment', 'refund', 'deposit'])->default('payment');
            $table->enum('payment_method', ['cash', 'card', 'online', 'other'])->default('cash');
            
            $table->decimal('amount', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2);
            
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            
            $table->text('description')->nullable();
            $table->string('reference_number', 100)->nullable(); // شماره مرجع پرداخت
            $table->json('meta_data')->nullable(); // اطلاعات اضافی
            
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'type']);
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