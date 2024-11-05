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

    public function createRoles($roles)
    {
        return $this->userrole->create($roles);
    }

    public function updateRoles($id, $roles)
    {
        return $this->userrole->update($id, $roles);
    }

    public function deleteRoles($id)
    {
        return $this->userrole->find($id)->delete();
    }
}