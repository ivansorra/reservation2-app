<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

class Membership extends Model
{
    use HasApiTokens;

    protected $table = "membership";
    protected $primaryKey = "membership_id";
    protected $fillable = [
        'membership_no',
        'status'
    ];

    // public $timestamps = false;

    public function users(){
        return $this->belongsToMany(User::class, 'member_user_pivot');
    }
}
