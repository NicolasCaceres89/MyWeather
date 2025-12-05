<?php

use App\Enums\GradeUnitType;
use App\Enums\TimeFormatType;
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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            //This is used to select and save the grade unit, that the user prefers
            $table->enum("temperature_unit", array_column(GradeUnitType::cases(), 'value'))->default(GradeUnitType::Farenheight->value);
            //Default value on twelve hours, with option to change to format of twenty four hours
            $table->enum("time_format", array_column(TimeFormatType::cases(), 'value'))->default(TimeFormatType::TwelveHours->value);
            $table->timestamps();
        });

        //Function to manage the foreing key for this table...
        Schema::table('preferences', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained(); //Find the column 'id' on table 'users' and then add it by user_id 1:1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
