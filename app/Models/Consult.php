<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    //Specific primary key for the consult model...
    protected $primaryKey = 'id';

    //This attributes of the consult model are mass assignable...
    protected $fillable = [
        //Waiting for attributes to be defined...
        //First is needed to connect the external API data with the user that made the consult...
    ];


}
