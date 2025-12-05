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
        Schema::create('favorite_locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('favorite_locations', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //Foreign key for connect with the user table...
            $table->foreignId('location_id')->constrained()->onDelete('cascade'); //Foreign key for connect with the location table...
            $table->unique(['user_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_locations');
    }
};
