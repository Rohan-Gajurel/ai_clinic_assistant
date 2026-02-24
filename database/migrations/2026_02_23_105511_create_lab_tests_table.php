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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('lab_categories')->onDelete('cascade');
            $table->foreignId('sample_id')->nullable()->constrained('lab_samples')->onDelete('cascade');
            $table->foreignId('method_id')->nullable()->constrained('lab_methods')->onDelete('cascade');
            $table->decimal('reference_from', 10, 2)->nullable();
            $table->decimal('reference_to', 10, 2)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('price', 10, 2)->unsigned()->nullable();
            $table->enum('result_type', ['numeric', 'text'])->default('numeric');
            $table->enum('testable', ['yes', 'no'])->default('yes');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
