<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->text('short_description')->nullable();
            $table->longText('seo_content')->nullable(); // متن سئو شده
            $table->longText('article_content')->nullable(); // مقاله کامل
            $table->integer('price');
            $table->integer('duration_minutes')->default(30);
            $table->boolean('is_active')->default(true);
            $table->integer('review_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};