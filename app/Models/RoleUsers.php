<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUsers extends Pivot
{
    protected $table = 'user_roles';
    protected $fillable = ['user_id', 'role_id', 'status'];
}
