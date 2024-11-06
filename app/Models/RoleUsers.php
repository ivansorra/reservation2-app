<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUsers extends Pivot
{
    protected $table = 'role_user';
    protected $primaryKey = 'id';
    protected $fillable = ['role_id', 'user_id', 'status'];
}
