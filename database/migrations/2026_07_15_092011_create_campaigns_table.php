<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('type', ['seasonal', 'birthday', 'followup', 'general'])->default('general');
            $table->text('description')->nullable();
            $table->text('message_template');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('notification_days_before')->default(0);
            $table->json('target_tags')->nullable(); // تگ‌های هدف
            $table->json('target_tiers')->nullable(); // سطوح هدف
            $table->boolean('is_active')->default(true);
            $table->boolean('is_automatic')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};