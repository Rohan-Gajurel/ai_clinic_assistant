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
        Schema::table('patients', function (Blueprint $table) {
           if (Schema::hasColumn('patients', 'email')) {
               $table->dropColumn('email');
           }
           if (Schema::hasColumn('patients', 'name')) {
               $table->dropColumn('name');
           }
           if (!Schema::hasColumn('patients', 'user_id')) {
               $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
           }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
