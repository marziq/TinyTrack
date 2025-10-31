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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['Waiting', 'Done'])->default('Waiting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
        });
    }
};