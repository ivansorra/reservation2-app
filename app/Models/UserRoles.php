<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_name', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user')
                    ->using(RoleUsers::class)
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
