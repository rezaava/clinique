<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('points');
            $table->enum('type', ['earned', 'spent'])->default('earned');
            $table->string('source', 100);
            $table->foreignId('source_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index('source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_points');
    }
};