<?php

namespace App\Repositories;

use App\Interface\MembershipInterface;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\RoleUsers;
use Carbon\Carbon;

class MembershipRepository implements MembershipInterface
{
    private $members, $users, $roles, $role_users;

    /**
     * Create a new class instance.
     */
    public function __construct(Membership $membership, User $user, RoleUsers $userrole, UserRoles $role)
    {
        $this->members = $membership;
        $this->users = $user;
        $this->roles = $role;
        $this->role_users = $userrole;
    }

    public function getMemberships($perPage = 10)
    {
        return $this->members->paginate($perPage);
    }

    public function getMembership($id)
    {
        return $this->members->where('membership_id', $id)->first();
    }

    public function getMembershipNo($member_no)
    {
        $member = $this->members->where('membership_no', $member_no)->first();
        // dd($member);
        $memberResp = [];

        if($member)
        {
            $user = $this->users->where('membership_id', $member->membership_id)->first();
            $role = $this->role_users->where('user_id', $user->user_id)->first();
            $roles = $this->roles->where('role_id', $role->role_id)->first();

            $memberResp = [
                'user_id' => $user->user_id,
                'membership_id' => $member->membership_id,
                'membership_no' => $member->membership_no,
                'member_name' => $user->name,
                'member_address' => $user->address,
                'email_address' => $user->email_address,
                'birthdate' => $user->birthdate,
                'user_status' => $user->user_status == 1 ? 'active' : 'inactive',
                'contact_no' => $user->contact_no,
                'role_name' => $roles->role_name,
                'status' => $roles->status == 1 ? 'active' : 'inactive'
            ];
        }

        return $memberResp;
    }

    // -=-------- This method will use only for "MEMBERS" that are existing in INTIMUS --------------------------------
    public function createMembership($data, $userData)
    {
        $member = $this->members->firstOrCreate(
            [
                'membership_no' => $data['membership_no'],
                'status' => $data['status']
            ]
        );

        $membershipId = $member->membership_id;

        $user = $this->users->firstOrCreate(
            [
                'membership_id' => $membershipId,
            ],
            [
                'name' => $userData['name'],
                'address' => $userData['address'] ?? null,
                'email_address' => $userData['email_address'] ?? null,
                'birthdate' => Carbon::parse($userData['birthdate'])->format('Y-m-d') ?? null,
                'contact_no' => $userData['contact_no'] ?? null,
                'user_status' => $userData['user_status']
            ]
        );

        if($data['mem_type'] === "member")
        {
            $user->user_roles()->attach(1, ['status' => 0]);
        }
        else if($data['mem_type'] === "spouse")
        {
            $user->user_roles()->attach(2, ['status' => 0]);
        }

        // Return both User and Membership for reference
        return [
            'membership' => $member,
            'user' => $user
        ];
    }
    // --------------------------------------------------------------------
    public function updateMembership($membershipId, $data)
    {
        $membership = $this->members->find($membershipId);

        if (!$membership) {
            throw new \Exception('Membership not found.');
        }

        $membership->update($data);

        return $membership;
    }

    public function deleteMembership($id)
    {
        $membership = $this->members->find($id);

        if (!$membership) {
            throw new \Exception('Membership not found.');
        }

        $users = $this->users->where('membership_id', $membership->membership_id);

        if($users)
        {
            $users->delete();
        }

        return $membership->delete();
    }


}
