<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCodes extends Model
{
    protected $table = 'qrcode';

    protected $primaryKey = 'qr_id';

    protected $fillable = [
        'user_id',
        'travel_id',
        'qr_content',
        'qr_url',
        'qr_expiration_start',
        'qr_expiration_end',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function travel()
    {
        return $this->hasMany(FlightReservation::class, 'travel_id', 'travel_id');
    }
}
