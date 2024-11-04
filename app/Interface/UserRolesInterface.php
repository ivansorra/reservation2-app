<?php

namespace App\Interface;

interface UserRolesInterface
{
    public function getRoles();
    public function getRole($id);
    public function createRoles($roles);
    public function updateRoles($id, $roles);
    public function deleteRoles($id);
}
