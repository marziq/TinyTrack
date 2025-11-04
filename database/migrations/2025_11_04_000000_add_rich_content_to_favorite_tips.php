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
        Schema::table('favorite_tips', function (Blueprint $table) {
            $table->text('rich_content')->nullable()->after('content');
            $table->string('image_url')->nullable()->after('rich_content');
            $table->string('video_url')->nullable()->after('image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorite_tips', function (Blueprint $table) {
            $table->dropColumn(['rich_content', 'image_url', 'video_url']);
        });
    }
};
