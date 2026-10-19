<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->string('name', 150);
            $table->string('phone', 20);

            $table->enum('type', ['online', 'in_person', 'phone'])
                ->default('in_person');

            $table->text('description')->nullable();
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('doctor_working_time_slot_id')
                ->nullable()
                ->constrained('doctor_working_time_slot')
                ->nullOnDelete();

            $table->date('consultation_date')->nullable();
            $table->boolean('any_time')->default(false);

            $table->decimal('price', 15, 2)->default(0);

            $table->enum('status', [
                'pending',
                'assigned',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->timestamp('assigned_at')->nullable();

            $table->text('result')->nullable();
            $table->text('recommendations')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('assigned_to');
            $table->index(
                'doctor_working_time_slot_id',
                'consultations_slot_id_index'
            );
            $table->index(
                ['doctor_working_time_slot_id', 'consultation_date'],
                'consultations_slot_date_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};