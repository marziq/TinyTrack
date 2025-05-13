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
        Schema::table('growths', function (Blueprint $table) {
            $table->dropColumn('growthdate'); // Remove the existing growthdate column
            $table->float('growthMonth')->after('baby_id'); // Add the new growthMonth column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('growths', function (Blueprint $table) {
            $table->dropColumn('growthMonth'); // Remove the growthMonth column
            $table->date('growthdate')->after('baby_id'); // Re-add the growthdate column
        });
    }
};
