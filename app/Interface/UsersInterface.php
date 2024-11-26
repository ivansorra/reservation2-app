<?php

namespace App\Interface;

interface UsersInterface
{
    public function getUsers();
    public function getUserById($id);
    public function getMemberUserId($id);
    public function addUser($data);
    public function updateUser($id, $data);
    public function deleteUser($id);
}
