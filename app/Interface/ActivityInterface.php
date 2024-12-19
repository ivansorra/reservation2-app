<?php

namespace App\Interface;

interface ActivityInterface
{
    public function getActivities();
    public function getActivity($id);
    public function createActivity(array $data);
    public function updateActivity($id, array $data);
    public function deleteActivity($id);
}
