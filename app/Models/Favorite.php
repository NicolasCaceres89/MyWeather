<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //Specific primary key for the favorite model...
    protected $primaryKey = 'favorite_id';

    //This attributes of the favorite model are mass assignable...
    protected $fillable = [
        'user_id',
        'location_id',
    ];

    //Relation to the User model (many-to-one)...
    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //Relation to the Location model (many-to-one)...
    public function location () {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
