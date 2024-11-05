<?php

namespace App\Repositories;

use App\Interface\MembershipInterface;
use App\Models\Membership;
use App\Models\User;

use Carbon\Carbon;

class MembershipRepository implements MembershipInterface
{
    private $members, $users;

    /**
     * Create a new class instance.
     */
    public function __construct(Membership $membership, User $user)
    {
        $this->members = $membership;
        $this->users = $user;
    }

    public function getMemberships($perPage = 10)
    {
        return $this->members->paginate($perPage);
    }

    public function getMembership($id)
    {
        return $this->members->find($id);
    }

    public function createMembership($data, $userData)
    {
        $member = $this->members->firstOrCreate(
            [
                'membership_no' => $data['membership_no'],
                'status' => $data['status']
            ]
        );

        $member->save();

        $membershipId = $member->membership_id;

        $user = $this->users->firstOrCreate(
            [
                'membership_id' => $membershipId,
            ],
            [
                'name' => $userData['name'],
                'email_address' => $userData['email_address'],
                'birthdate' => Carbon::parse($userData['birthdate'])->format('Y-m-d'),
                'contact_no' => $userData['contact_no'],
                'user_status' => $userData['user_status']
            ]
        );

        // Return both User and Membership for reference
        return [
            'membership' => $member,
            'user' => $user
        ];
    }


    public function updateMembership($id, $data)
    {
        return $this->members->update($id, $data);
    }

    public function deleteMembership($id)
    {
        return $this->members->find($id)->delete();
    }
}
