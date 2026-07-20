<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone_number', 20);
            $table->text('message');
            $table->string('type', 50); // مناسبتی، تولد، فالوآپ، ...
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 20)->default('pending'); // pending, sent, failed
            $table->text('response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index('status');
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};