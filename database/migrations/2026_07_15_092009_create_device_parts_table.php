<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('part_number', 100)->nullable();
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete(); // وابسته به دستگاه
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('max_shots')->nullable(); // حداکثر شات
            $table->integer('used_shots')->default(0);
            $table->date('installation_date')->nullable();
            $table->date('replacement_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('users')->nullOnDelete(); // تأمین‌کننده
            $table->timestamps();
            $table->softDeletes();

            $table->index('device_id');
            $table->index('brand_id');
            $table->index('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_parts');
    }
};