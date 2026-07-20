<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['online', 'in_person', 'phone'])->default('in_person');
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->text('result')->nullable();
            $table->text('recommendations')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('assigned_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};