<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('working_days', function (Blueprint $table) {
            $table->id();
            $table->string('name_fa');
            $table->string('name_en');
            $table->unsignedTinyInteger('day');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('working_days');
    }
};