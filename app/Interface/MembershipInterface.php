<?php

namespace App\Interface;

interface MembershipInterface
{
    public function getMemberships();
    public function getMembership($id);
    public function getMembershipNo($member_no, $travel_id);
    public function createMembership(array $data, array $userData, array $reserveData);
    public function updateMembership($id, $data);
    public function deleteMembership($id);
}
