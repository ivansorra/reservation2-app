<?php

namespace App\Services;

use App\Repositories\MembershipRepository;
use App\Repositories\FlightReservationRepository;

// ----------- Custom Requests -----------------
use App\Http\Requests\MembershipRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FlightReservationRequest;
use App\Repositories\EmergencyDetailsRepositories;
// --------------------------------------

// ----------- Laravel Requests ----------------
use Illuminate\Http\Request;
// ---------------------------------------------

// ----------- Json Response -------------------
use Illuminate\Http\JsonResponse;
// ---------------------------------------------

// ----------- Laravel Traits ------------------
use App\Traits\ResponseTraits;
use App\Traits\APIRequestTrait;
// ---------------------------------------------

// ----------- Laravel Dates -------------------
use Carbon\Carbon;

use function PHPUnit\Framework\isEmpty;

class MembershipServices
{
    use ResponseTraits, APIRequestTrait;

    private $membershipRepository, $reservationRepository, $emergencyRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(MembershipRepository $memberRepository, FlightReservationRepository $reservationRepo, EmergencyDetailsRepositories $emergencyRepo)
    {
        $this->membershipRepository = $memberRepository;
        $this->reservationRepository = $reservationRepo;
        $this->emergencyRepository = $emergencyRepo;
    }

    public function getMembersList(Request $request){
        try {
            $limit = $request->get('limit') ?? 10;

            $members_list = $this->membershipRepository->getMemberships($limit);

            return $this->successResponse($members_list, 'Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function intimusMemberData(Request $request)
    {
        try {
            $get_intimus_res = $this->get_intimus_members($request);

            if($get_intimus_res)
            {
                return $this->successResponse($get_intimus_res, 'Successfully Called API', 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function getMemberById(Request $request)
    {
        try {
            $get_member_id = $this->get_intimus_members($request);
            $responseData = $get_member_id->getData(true);

            // Validate API response structure
            if (!isset($responseData['data']) || !is_array($responseData['data'])) {
                return $get_member_id;
            }

            // Prepare validated data
            $membersValidatedData = [
                'membership_no' => $responseData['data']['member_number'],
                'mem_type' => null,
                'status' => true,
            ];

            if ($responseData['data']['relation'] === "DESCENDANTS") {
                $membersValidatedData['mem_type'] = $responseData['data']['relation'];
                return response()->json([
                    'success' => false,
                    'data' => $membersValidatedData,
                    'message' => "You're a descendant. Kindly proceed as guest to continue"
                ]);
            }

            $membersValidatedData['mem_type'] = $request->get('mem_type');

            $usersValidatedData = [
                'name' => $responseData['data']['member_name'] ?? null,
                'address' => $responseData['data']['address']['address'] ?? null,
                'email_address' => $responseData['data']['member_email'] ?? null,
                'birthdate' => $responseData['data']['birthdate'] ?? null,
                'contact_no' => $responseData['data']['phone_number'] ?? null,
                'user_status' => true,
            ];

            $getExistingMember = $this->membershipRepository->getMembershipNo($responseData['data']['member_number']);

            if ($getExistingMember) {
                $user_id = $getExistingMember['user_id'];
                $hasEmergencyDetails = $this->emergencyRepository->getEmergencyDetail($user_id);
                $reservation_exists = $this->reservationRepository->getReservation(null, $user_id);

                if ($hasEmergencyDetails) {
                    $getExistingMember['emergencyContact'] = [
                        'name' => $hasEmergencyDetails['name'] ?? null,
                        'address' => $hasEmergencyDetails['address'] ?? null,
                        'contact_no' => $hasEmergencyDetails['contact_no'] ?? null,
                        'relationship' => $hasEmergencyDetails['relationship'] ?? null,
                    ];
                }

                if ($reservation_exists) {
                    $getExistingMember['arrival_date'] = $reservation_exists['arrival_date'] ?? null;
                    $getExistingMember['return_date'] = $reservation_exists['return_date'] ?? null;
                    $getExistingMember['travel_id'] = $reservation_exists['travel_id'] ?? null;
                }

                return $this->successResponse($getExistingMember, 'User already exists', 200);
            } else {
                $flightReserveReq = [
                    'arrival_date' => !empty($responseData['data']['arrival_date']) ? Carbon::parse($responseData['data']['arrival_date'])->format('Y-m-d') : null,
                    'return_date' => !empty($responseData['data']['return_date']) ? Carbon::parse($responseData['data']['return_date'])->format('Y-m-d') : null,
                ];

                $create_member = $this->membershipRepository->createMembership($membersValidatedData, $usersValidatedData, $flightReserveReq);

                if ($create_member) {
                    $getExistingMember = $this->membershipRepository->getMembershipNo(
                        $responseData['data']['member_number'],
                        $create_member['reservation']['travel_id'] ?? null
                    );

                    if (!empty($create_member['reservation'])) {
                        $getExistingMember['travel_id'] = $create_member['reservation']['travel_id'];
                    }

                    return $this->successResponse($getExistingMember, 'Successfully added new member', 200);
                }

                return response()->json([
                    'success' => false,
                    'error'   => 'Failed to create new member',
                ], 400);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function createNewMember(Request $request, MembershipRequest $memberRequest, UserRequest $userRequest)
    {
        try {
            $membersValidator = $memberRequest->authorize($request);
            $usersValidator = $userRequest->authorize($request);

            if ($membersValidator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $membersValidator;
            }

            if ($usersValidator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $usersValidator;
            }

            $membersValidatedData = $membersValidator->validated();

            $membersValidatedData['status'] = $membersValidatedData['status'] == 'active' ? true : false;

            $usersValidatedData = $usersValidator->validated();

            $usersValidatedData['user_status'] = $usersValidatedData['user_status'] == 'active' ? true : false;

            // $flightReserveReq = [
            //     'arrival_date' => Carbon::parse($get_member_id['arrival_date'])->format('Y-m-d') ?? null,
            //     'return_date'  => null,
            // ];

            $create_member = $this->membershipRepository->createMembership($membersValidatedData, $usersValidatedData, []);

            return $this->successResponse($create_member, 'Success', 200);

        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 500);
        }
    }

    public function updateMember(Request $request, MembershipRequest $memberRequest)
    {
        try {
            $validator = $memberRequest->authorize($request);

            if($validator instanceof JsonResponse)
            {
                return $validator;
            }

            $validatedData = $validator->validated();

            $update_member = $this->membershipRepository->updateMembership($validatedData['membership_id'], $validatedData);

            return $this->successResponse($update_member, 'Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }
    public function deleteMember(Request $request)
    {
        try {
            $member_id = $request->get('member_id');
            $delete_member = $this->membershipRepository->deleteMembership($member_id);
            return $this->successResponse(null, 'Membership and associated users deleted successfully.', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

}
