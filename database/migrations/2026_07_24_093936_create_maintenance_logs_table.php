<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('type', ['regular', 'emergency', 'repair', 'replacement'])->default('regular');
            $table->date('maintenance_date');
            $table->text('description')->nullable();
            $table->text('parts_replaced')->nullable();
            $table->text('notes')->nullable();
            
            $table->decimal('cost', 15, 2)->default(0);
            $table->date('next_maintenance_date')->nullable();
            
            $table->timestamps();

            $table->index(['device_id', 'maintenance_date']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};