<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('request_number', 50)->unique();
            $table->enum('type', ['consumable', 'device_part', 'device'])->default('consumable');
            $table->enum('status', ['pending', 'approved', 'rejected', 'ordered', 'received', 'cancelled'])->default('pending');
            
            $table->text('description')->nullable();
            $table->decimal('total_price', 15, 2)->default(0);
            $table->date('expected_delivery_date')->nullable();
            $table->date('received_date')->nullable();
            
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('request_number');
            $table->index('status');
            $table->index('type');
            $table->index('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};