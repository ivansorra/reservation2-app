<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyDetails extends Model
{
    protected $table = 'emergency_details';
    protected $primaryKey = 'emergency_id';
    protected $fillable = [
        'user_id',
        'name',
        'contact_no',
        'address',
        'relationship'
    ];
}
