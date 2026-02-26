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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->decimal('gross_amount', 10, 2)->unsigned();
            $table->decimal('discount_amount', 10, 2)->unsigned()->default(0);
            $table->decimal('net_amount', 10, 2)->unsigned();
            $table->enum('status', ['pending', 'cancelled', 'confirmed'])->default('pending');
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('bill_items',function(Blueprint $table){
            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            $table->string('service_name');
            $table->integer('quantity')->unsigned()->default(1);
            $table->decimal('rate', 10, 2)->unsigned();
            $table->decimal('amount', 10, 2)->unsigned();
            $table->decimal('discount', 10, 2)->unsigned()->default(0);
            $table->decimal('net_amount', 10, 2)->unsigned();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill');
        Schema::dropIfExists('bill_items');
    }
};
