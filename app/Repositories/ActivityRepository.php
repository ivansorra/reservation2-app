<?php

namespace App\Repositories;

use App\Interface\ActivityInterface;

use App\Models\Activities;

use App\Models\RoleUsers;
use App\Models\UserRoles;

class ActivityRepository implements ActivityInterface
{
    /**
     * Create a new class instance.
     */
    private $act, $role_pivot, $user_roles;

    public function __construct(Activities $activity, RoleUsers $pivot_role, UserRoles $user_roles)
    {
        $this->act = $activity;
        $this->role_pivot = $pivot_role;
        $this->user_roles = $user_roles;
    }

    public function getActivities($perPage = 10)
    {
        $activities = $this->act->with(['user', 'travel'])->paginate($perPage);

        foreach ($activities as $activity) {
            $roles = $this->role_pivot->where('user_id', $activity->user_id)->first();

            if ($roles) {
                $user_roles = $this->user_roles->where('role_id', $roles->role_id)->first();
                $activity->role = $user_roles;
            }
        }

        return $activities;
    }


    public function getActivity($id)
    {
        return $this->act->find($id);
    }

    public function createActivity($data)
    {
        return $this->act->firstOrCreate($data);
    }

    public function updateActivity($id, $data)
    {
        return $this->act->where('activity_id', $id)->update($data);
    }

    public function deleteActivity($id)
    {
        return $this->act->where('activity_id', $id)->delete();
    }
}
