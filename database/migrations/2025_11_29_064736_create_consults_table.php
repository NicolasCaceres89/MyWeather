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
        Schema::create('consults', function (Blueprint $table) {
            $table->id();
            $table->string('search_term')->nullable(); //Search term used by the user
            $table->boolean('was_successful')->default(false); //Whether the API call was successful
            $table->timestamps();

            //Search by create_at and updated_at timestamps...
            $table->index('created_at');
        });

        //Function to manage the foreing key for this table...
        Schema::table('consults', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //Find the column 'id' on table 'users' and then add it by user_id
            $table->foreignId('location_id')->constrained()->onDelete('cascade'); //Find the column 'id' on table 'locations' and then add it by location_id
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consults');
    }
};
