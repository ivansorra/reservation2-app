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

    public function getUsersByName($name)
    {
        return $this->users->where('name', $name)->first();
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
        try {
            // Use firstOrCreate to find or create a user
            $user = $this->users->firstOrCreate(
                [
                    'membership_id' => $data['membership_id'],
                    'name' => $data['name'], // Assuming name is unique for users
                ],
                [
                    'name' => $data['name'],
                    'email_address' => $data['email_address'],
                    'address' => $data['address'],
                    'birthdate' => isset($data['birthdate']) ? Carbon::parse($data['birthdate'])->format('Y-m-d') : null,
                    'contact_no' => $data['contact_no'],
                    'user_status' => $data['user_status'],
                ]
            );

            // Attach user role if provided and not already attached
            if (isset($data['role_id'], $data['user_role_status'])) {
                $user->user_roles()->syncWithoutDetaching([
                    $data['role_id'] => ['status' => $data['user_role_status']],
                ]);
            }

            return $user;
        } catch (\Exception $e) {
            // Handle errors gracefully
            throw new \Exception("Error adding user: " . $e->getMessage());
        }
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
