<?php

namespace App\Models;

use App\Enums\GradeUnitType;
use App\Enums\TimeFormatType;
use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    //Specific primary key for the preferences model...
    protected $primaryKey = 'id';
    
    //This attributes of the preference model are mass assignable...
    protected $attributes = [
        'temperature_unit' => GradeUnitType::Farenheight->value,
        'time_format' => TimeFormatType::TwelveHours->value,
    ];
    
    //Relation to the User model (one-to-one)...
    public function user () {
        return $this->belongsTo(User::class);
    }
}
