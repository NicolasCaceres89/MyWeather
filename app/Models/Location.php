<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //Specific primary key for the location model...
    protected $primaryKey = 'id';

    //This attributes of the location model are mass assignable...
    protected $fillable = [
        'cityName',
        'latitude',
        'longitude',
        'name',
        'country',
    ];

    //Relation to the Favorite model (one-to-many)...
    public function favorites() {
        return $this->hasMany(Favorite::class, 'location_id', 'id');
    }

    //Relation to the Consult model (one-to-many)...
    public function consults() {
        return $this->hasMany(Consult::class, 'location_id', 'id');
    }
}
