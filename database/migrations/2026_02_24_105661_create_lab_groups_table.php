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
        Schema::create('lab_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('charge_amount', 10, 2)->unsigned()->nullable();
            $table->foreignId('category_id')->constrained('lab_categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for lab_groups and lab_tests
        Schema::create('lab_group_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('lab_groups')->onDelete('cascade');
            $table->foreignId('test_id')->constrained('lab_tests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_group_test');
        Schema::dropIfExists('lab_groups');
    }
};
