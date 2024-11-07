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

    // Define a one-to-many relationship to User
    public function users()
    {
        return $this->hasMany(User::class, 'membership_id');
    }

    // Pagination method to fetch paginated users for this membership
    public function getUserMembers($perPage = 10)
    {
        return $this->users()->paginate($perPage);
    }
}
