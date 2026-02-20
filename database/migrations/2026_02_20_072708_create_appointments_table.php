<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('doctor_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->date('appointment_date');

            $table->time('start_time');
            $table->time('end_time');

            $table->enum('status', [
                'pending',
                'approved',
                'reminded',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->text('reason')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->foreignId('rescheduled_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['doctor_id', 'appointment_date', 'start_time'],
                'doctor_slot_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
