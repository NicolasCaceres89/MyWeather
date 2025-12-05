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
        //Creation of locations DB table...
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('cityName');
            
            //Coordenates of the location...
            $table->double('latitude');
            $table->double('longitude');

            //Making the coordenates of locations unique, for non duplications...
            $table->unique(['latitude', 'longitude']);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
