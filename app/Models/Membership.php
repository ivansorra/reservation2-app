<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Membership extends Model
{
    protected $table = "membership";
    protected $primaryKey = "membership_id";
    protected $fillable = [
        'membership_no',
        'status'
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
