<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $table = 'activity';

    protected $primaryKey = 'activity_id';

    protected $fillable = [
        'user_id',
        'travel_id',
        'activity_name',
        'location'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function travel(){
        return $this->belongsTo(FlightReservation::class, 'travel_id', 'travel_id');
    }

}
