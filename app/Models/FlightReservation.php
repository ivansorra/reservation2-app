<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightReservation extends Model
{
    protected $table = "flight_reservation";

    protected $primaryKey = "travel_id";

    protected $fillable = [
        'user_id',
        'arrival_date',
        'return_date',
    ];
}
