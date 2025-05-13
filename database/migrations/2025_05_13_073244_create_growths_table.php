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
        Schema::create('growths', function (Blueprint $table) {
            $table->id('growthID');
            $table->foreignId('baby_id')->constrained()->onDelete('cascade');
            $table->date('growthdate');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('head_circumference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growths');
    }
};
