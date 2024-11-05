<?php

namespace App\Interface;

interface MembershipInterface
{
    public function getMemberships();
    public function getMembership($id);
    public function createMembership(array $data, array $userData);
    public function updateMembership($id, $data);
    public function deleteMembership($id);
}
