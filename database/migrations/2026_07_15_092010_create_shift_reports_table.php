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
            $table->string('shift_number', 50)->nullable()->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('shift_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('shots_used')->default(0);
            $table->text('consumables_used')->nullable();
            $table->text('device_parts_used')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_received')->default(false);
            $table->timestamp('received_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
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