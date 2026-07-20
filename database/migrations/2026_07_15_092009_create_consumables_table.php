<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('sku', 100)->unique()->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->string('unit', 20)->default('عدد'); // واحد شمارش
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('users')->nullOnDelete(); // تأمین‌کننده
            $table->timestamps();
            $table->softDeletes();

            $table->index('brand_id');
            $table->index('supplier_id');
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumables');
    }
};