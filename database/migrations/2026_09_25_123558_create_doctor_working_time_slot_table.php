<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_working_time_slot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('working_time_slot_id')
                ->constrained('working_time_slots')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'user_id',
                'working_time_slot_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_working_time_slot');
    }
};