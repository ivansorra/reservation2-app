<?php

namespace App\Repositories;

use App\Interface\EmergencyDetailsInterface;
use App\Models\EmergencyDetails;

class EmergencyDetailsRepositories implements EmergencyDetailsInterface
{
    private $details;
    /**
     * Create a new class instance.
     */
    public function __construct(EmergencyDetails $emergencyDetails)
    {
        $this->details = $emergencyDetails;
    }

    public function getEmergencyDetails($perPage = 10)
    {
        return $this->details->paginate($perPage);
    }

    public function getEmergencyDetail($user_id = null)
    {
        $emergencyDetails = $this->details->where('user_id', $user_id)->first();
        // return $this->details->where('emergency_id', $id)->first();
        return $emergencyDetails;
    }

    public function createEmergencyDetail($data)
    {
        $emergency_details = $this->details->firstOrCreate([
            'user_id' => $data['user_id'],
            'name' => $data['emergency_contact_name'],
            'contact_no' => $data['emergency_contact_no'],
            'address' => $data['emergency_contact_address'],
            'relationship' => $data['relationship'],
        ]);

        return $emergency_details;
    }

    public function updateEmergencyDetail($id, $data)
    {
        $find_detail_id = $this->details->find($id);

        if(!$find_detail_id)
        {
            throw new \Exception('Emergency details not found.');
        }

        $find_detail_id->update($data);

        return $find_detail_id;
    }

    public function deleteEmergencyDetail($id)
    {
        $find_detail = $this->details->find($id);

        if(!$find_detail)
        {
            throw new \Exception('Emergency details not found.');
        }

        $find_detail->delete();

        return $find_detail;
    }
}
