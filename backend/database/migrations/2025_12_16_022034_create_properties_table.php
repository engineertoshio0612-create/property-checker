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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->boolean('is_corner')->default(false);
            $table->unsignedSmallInteger('distance_convenience_store')->nullable(); // meters
            $table->unsignedTinyInteger('sunlight_score')->nullable(); // 1-5
            $table->unsignedTinyInteger('noise_score')->nullable(); // 1-5

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
