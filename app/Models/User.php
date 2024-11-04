<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membership_id',
        'name',
        'email_address',
        'role_id',
        'birthdate',
        'contact_no',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function membership(){
        return $this->hasOne(Membership::class);
    }

    public function accounts(){
        return $this->hasOne(Accounts::class);
    }

    public function user_roles()
    {
        return $this->belongsToMany(UserRoles::class, 'role_user')
                    ->using(RoleUsers::class) // Reference the pivot model if needed
                    ->withPivot('status', 'created_at', 'updated_at') // Include additional fields on the pivot
                    ->withTimestamps();
    }
}
