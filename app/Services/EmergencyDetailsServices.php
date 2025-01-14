<?php

namespace App\Services;

use App\Repositories\EmergencyDetailsRepositories;

// ----------- Laravel Requests ----------------
use App\Http\Requests\EmergencyDetailsRequest;
use Illuminate\Http\Request;
// ---------------------------------------------

// ----------- Json Response -------------------
use Illuminate\Http\JsonResponse;
// ---------------------------------------------

// ----------- Laravel Traits ------------------
use App\Traits\ResponseTraits;
// ---------------------------------------------

class EmergencyDetailsServices
{
    use ResponseTraits;

    private $emergencyDetailRepo;
    /**
     * Create a new class instance.
     */
    public function __construct(EmergencyDetailsRepositories $emergencyDetails)
    {
        $this->emergencyDetailRepo = $emergencyDetails;
    }

    public function getEmergencyDetails(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;
            $emergencyDetails = $this->emergencyDetailRepo->getEmergencyDetails($limit);

            return $this->successResponse($emergencyDetails, 'Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function getSingleEmergencyDetail(Request $request)
    {
        try {
            // $emergency_detail_id = $request->get('emergency_detail_id');
            $user_id = $request->get('user_id');

            $emergencyDetail = $this->emergencyDetailRepo->getEmergencyDetail($user_id);

            return $this->successResponse($emergencyDetail, 'Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function createEmergencyDetail(Request $request, EmergencyDetailsRequest $emergencyDetailsReq)
    {
        try {

            $validator = $emergencyDetailsReq->authorize($request);

            if($validator instanceof JsonResponse) {
                return $validator;
            }

            $validatedData = $validator->validated();

            $create_emergency_detail = $this->emergencyDetailRepo->createEmergencyDetail($validatedData);

            return $this->successResponse($create_emergency_detail, "Successfully created emergency detail", 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function updateEmergencyDetail(Request $request, EmergencyDetailsRequest $emergencyDetailsReq)
    {
        try {
            $validate = $emergencyDetailsReq->authorize($request);

            if ($validate instanceof JsonResponse) {
                return $validate;
            }

            $validatedData = $validate->validated();
            $detail_id = $request->get('emergency_detail_id');

            $updated_reservation = $this->emergencyDetailRepo->updateEmergencyDetail($detail_id, $validatedData);

            return $this->successResponse($updated_reservation, 'Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function deleteEmergencyDetail(Request $request)
    {
        try {
            $detail_id = $request->get('emergency_detail_id');

            $delete_emergency_detail = $this->emergencyDetailRepo->deleteEmergencyDetail($detail_id);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }
}
