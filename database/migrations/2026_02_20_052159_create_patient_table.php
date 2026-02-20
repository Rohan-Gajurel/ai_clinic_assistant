<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('full_name');
            $table->integer('age');
            $table->string('age_unit')->default('years'); 
            $table->date('date_of_birth')->nullable();
            $table->enum('sex', ['male', 'female', 'other']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('address');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->enum('id_card_type', ['passport', 'citizenship','driver_license', 'national_id'])->nullable();
            $table->string('id_card_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('patient_type')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('local_level')->nullable();
            $table->string('ward_number')->nullable();
            $table->string('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
