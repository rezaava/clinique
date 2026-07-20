<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_consumable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('consumable_id')->constrained()->cascadeOnDelete();
            $table->integer('price')->nullable();
            $table->timestamps();

            $table->unique(['supplier_id', 'consumable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_consumable');
    }
};