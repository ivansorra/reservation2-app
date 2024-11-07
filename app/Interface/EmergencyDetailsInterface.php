<?php

namespace App\Interface;

interface EmergencyDetailsInterface
{
    public function getEmergencyDetails();
    public function getEmergencyDetail($id);
    public function createEmergencyDetail(array $data);
    public function updateEmergencyDetail($id, array $data);
    public function deleteEmergencyDetail($id);
}
