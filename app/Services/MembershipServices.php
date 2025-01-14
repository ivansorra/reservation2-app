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
            if ($get_member_id) {
                $membersValidatedData = [
                    'membership_no' => $get_member_id['member_number'] ?? null,
                    'mem_type' => null,
                    // 'arrivalDate' => $get_member_id['nextArrDt'] ?? null,
                    'status' => true,
                ];

                if($get_member_id['relation'] === "DESCENDANTS")
                {
                    $membersValidatedData['mem_type'] = $get_member_id['relation'];
                    return response()->json([
                        'success' => false,
                        'data' => $membersValidatedData,
                        'message' => "You're a descendant. Kindly proceed as guest to continue"
                    ]);
                }

                $membersValidatedData['mem_type'] = $request->get('mem_type');

                $usersValidatedData = [
                    'name' => $get_member_id['member_name'] ?? null,
                    'address' => $get_member_id['address']['address'],
                    'email_address' => $get_member_id['member_email'],
                    'birthdate' => Carbon::parse($get_member_id['birthday'])->format('m-d-Y'),
                    'contact_no' => $get_member_id['phone_number'],
                    'user_status' => true,
                ];

                // dd($usersValidatedData);
                $getExistingMember = $this->membershipRepository->getMembershipNo($get_member_id['member_number']);

                if ($getExistingMember) {
                    $user_id = $getExistingMember['user_id'];

                    $hasEmergencyDetails = $this->emergencyRepository->getEmergencyDetail($user_id);

                    $reservation_exists = $this->reservationRepository->getReservation(null, $user_id);

                    if($hasEmergencyDetails)
                    {
                        $getExistingMember['emergencyContact'] = [
                            'name' => $hasEmergencyDetails['name'],
                            'address' => $hasEmergencyDetails['address'],
                            'contact_no' => $hasEmergencyDetails['contact_no'],
                            'relationship' => $hasEmergencyDetails['relationship'],
                        ];

                        // $getExistingMember['contactName'] = $hasEmergencyDetails['name'];
                        // $getExistingMember['contactAddress'] = $hasEmergencyDetails['address'];
                        // $getExistingMember['contactNumber'] = $hasEmergencyDetails['contact_no'];
                        // $getExistingMember['contactRelation'] = $hasEmergencyDetails['relationship'];
                    }

                    if($reservation_exists)
                    {
                        $getExistingMember['arrival_date'] = $reservation_exists['arrival_date'];
                        $getExistingMember['return_date'] = $reservation_exists['return_date'];
                        $getExistingMember['travel_id'] = $reservation_exists['travel_id'];
                    }

                    // dd($getExistingMember);
                    return $this->successResponse($getExistingMember, 'User already exists', 200);
                } else {
                    // $currentDate = Carbon::now();

                    // $daysDifference = Carbon::parse($get_member_id['arrival_date'])->diffInDays($currentDate);

                    // if ($daysDifference <= 30) {
                    $flightReserveReq = [
                        'arrival_date' => $get_member_id['arrival_date']  !== "" ? Carbon::parse($get_member_id['arrival_date'])->format('Y-m-d') : null,
                        'return_date'  => $get_member_id['return_date']  !== "" ? Carbon::parse($get_member_id['return_date'])->format('Y-m-d') : null,
                    ];

                    $create_member = $this->membershipRepository->createMembership($membersValidatedData, $usersValidatedData, $flightReserveReq);
                    // } else {
                    //     $create_member = $this->membershipRepository->createMembership($membersValidatedData, $usersValidatedData, null);
                    // }

                    // dd($create_member);

                    if ($create_member) {
                        if($create_member['reservation'] === [])
                        {
                            $getExistingMember = $this->membershipRepository->getMembershipNo($get_member_id['member_number'], null);
                        }
                        else {
                            $getExistingMember = $this->membershipRepository->getMembershipNo($get_member_id['member_number'], $create_member['reservation']['travel_id']);
                            $getExistingMember['travel_id'] = $create_member['reservation']['travel_id'];
                        }

                        return $this->successResponse($getExistingMember, 'Successfully added new member', 200);
                    }

                    return response()->json([
                        'success' => false,
                        'error'   => 'Failed to create new member',
                    ], 400);

                }
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
