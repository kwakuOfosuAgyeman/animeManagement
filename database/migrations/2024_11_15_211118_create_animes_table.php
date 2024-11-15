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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('title_english')->nullable();
            $table->string('title_japanese')->nullable();
            $table->text('synopsis');
            $table->text('background')->nullable();
            $table->integer('episodes')->nullable();
            $table->string('rating')->nullable();
            $table->float('score')->nullable();
            $table->integer('scored_by')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('popularity')->nullable();
            $table->integer('members')->nullable();
            $table->integer('favorites')->nullable();
            $table->string('image_url')->nullable();
            $table->string('type')->nullable();
            $table->string('duration')->nullable();
            $table->string('source')->nullable();
            $table->string('season')->nullable();
            $table->integer('year')->nullable();
            $table->json('genres')->nullable();
            $table->json('studios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
