<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->integer('warranty_months')->nullable();
            $table->integer('total_shots_limit')->nullable();
            $table->integer('used_shots')->default(0);
            $table->date('last_maintenance_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'maintenance', 'broken', 'retired'])->default('active');
            
            // تامین‌کننده اصلی (1 به چند)
            $table->foreignId('supplier_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('brand_id');
            $table->index('supplier_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};