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
        Schema::table('users', function (Blueprint $table) {
            $table->string('website')->nullable()->after('mobile_number');
            $table->string('github')->nullable()->after('website');
            $table->string('twitter')->nullable()->after('github');
            $table->string('instagram')->nullable()->after('twitter');
            $table->string('facebook')->nullable()->after('instagram');
            $table->string('address')->nullable()->after('facebook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['website', 'github', 'twitter', 'instagram', 'facebook', 'address']);
        });
    }
};
