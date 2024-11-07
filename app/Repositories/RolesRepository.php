<?php

namespace App\Repositories;

use App\Interface\UserRolesInterface;
use App\Models\UserRoles;

class RolesRepository implements UserRolesInterface
{
    protected $userrole;

    public function __construct(UserRoles $userroles)
    {
        $this->userrole = $userroles;
    }

    public function getRoles($perPage = 10)
    {
        return $this->userrole->paginate($perPage);
    }

    public function getRole($id)
    {
        return $this->userrole->find($id);
    }

    public function getRoleByName($name)
    {
        return $this->userrole->where('role_name', $name)->first();
    }

    public function createRoles($roles)
    {
        return $this->userrole->create($roles);
    }

    public function updateRoles($id, $roles)
    {
        $role = $this->userrole->find($id);

        if (!$role) {
            throw new \Exception('User role not found.');
        }

        $role->update($roles);

        return $role;
    }

    public function deleteRoles($id)
    {
        return $this->userrole->find($id)->delete();
    }
}
