<?php

namespace App\Repositories;

use App\Interface\UsersInterface;
use App\Models\User;

use Carbon\Carbon;

class UserRepository implements UsersInterface
{
    private $users;
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        $this->users = $user;
    }

    public function getUsers($perPage = 10)
    {
        return $this->users->paginate($perPage);
    }

    public function getUserById($id)
    {
        return $this->users->where('user_id', $id)->first();
    }

    public function getMemberUserId($id)
    {
        return $this->users->where('membership_id', $id)->first();
    }

    public function addUser($data)
    {

        $user = $this->users->firstOrCreate([
            'membership_id' => $data['membership_id'],
            'name' => $data['name'],
            'address' => $data['address'],
            'email_address' => $data['email_address'],
            'birthdate' => Carbon::parse($data['birthdate'])->format('Y-m-d'),
            'contact_no' => $data['contact_no'],
            'user_status' => $data['user_status'],
        ]);

        $user->user_roles()->attach($data['role_id'], ['status' => $data['user_role_status']]);

        return $user;
    }

    public function updateUser($id, $user)
    {
        $users = $this->users->find($id);

        if (!$users) {
            throw new \Exception('User not found.');
        }

        $users->update($user);

        return $users;
    }

    public function deleteUser($id)
    {
        $users = $this->users->find($id);

        if(!$users)
        {
            throw new \Exception('User not found.');
        }

        $users->user_roles()->updateExistingPivot($users['role_id'], ['status' => 1]);
    }
}
