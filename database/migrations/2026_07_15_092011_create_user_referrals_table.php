<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_id')->constrained('users')->cascadeOnDelete();
            $table->string('referral_code', 20);
            $table->enum('status', ['pending', 'active', 'completed'])->default('pending');
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('first_purchase_at')->nullable();
            $table->integer('commission_points')->default(0);
            $table->timestamps();

            $table->unique(['referrer_id', 'referred_id']);
            $table->index('referral_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_referrals');
    }
};