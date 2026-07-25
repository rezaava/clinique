<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('inventoriable'); // این خودش ایندکس ایجاد میکنه
            
            $table->enum('type', ['purchase', 'sale', 'usage', 'return', 'adjustment', 'waste'])->default('purchase');
            $table->enum('direction', ['in', 'out'])->default('in');
            
            $table->integer('quantity');
            $table->integer('previous_quantity')->default(0);
            $table->integer('current_quantity')->default(0);
            
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('total_price', 15, 2)->nullable();
            
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('purchase_request_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamp('transaction_date')->useCurrent();
            
            $table->timestamps();

            
            $table->index('type');
            $table->index('direction');
            $table->index('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};