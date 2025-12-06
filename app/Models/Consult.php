<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    //Specific primary key for the consult model...
    protected $primaryKey = 'id';

    //This attributes of the consult model are mass assignable...
    protected $fillable = [
        'user_id',
        'location_id',
        'search_term',
        'was_successful',
    ];

    //Cast attributes to specific types...
    protected function casts(): array
    {
        return [
            'was_successful' => 'boolean',
        ];
    }

    //Relationships...
    //This belongs to a user...
    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    //This belongs to a location...
    public function location () {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
