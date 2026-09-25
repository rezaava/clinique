<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('working_time_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('working_day_id')
                ->constrained('working_days')
                ->cascadeOnDelete();

            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('working_time_slots');
    }
};