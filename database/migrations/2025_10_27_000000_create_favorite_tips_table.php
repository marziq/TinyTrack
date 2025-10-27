<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorite_tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tip_id');
            $table->string('title');
            $table->text('content');
            $table->string('category');
            $table->timestamps();
            // Add unique constraint to prevent duplicate favorites
            $table->unique(['user_id', 'tip_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_tips');
    }
};
