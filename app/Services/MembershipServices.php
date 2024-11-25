<?php

namespace App\Services;

use App\Repositories\MembershipRepository;

// ----------- Custom Requests -----------------
use App\Http\Requests\MembershipRequest;
use App\Http\Requests\UserRequest;
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

class MembershipServices
{
    use ResponseTraits, APIRequestTrait;

    private $membershipRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(MembershipRepository $memberRepository)
    {
        $this->membershipRepository = $memberRepository;
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

    public function getMemberById(Request $request)
    {
        try {
            $get_member_id = $this->get_intimus_members($request);
            if ($get_member_id) {
                $membersValidatedData = [
                    'membership_no' => $get_member_id['member_number'] ?? null,
                    'status' => true,
                ];

                $usersValidatedData = [
                    'name' => $get_member_id['member_name'] ?? null,
                    'address' => "123 Sample St",
                    'email_address' => 'issorra@alphaland.com.ph',
                    'birthdate' => Carbon::parse('01/11/1998')->format('Y-m-d'),
                    'contact_no' => "09120429426",
                    'user_status' => true,
                ];

                $getExistingMember = $this->membershipRepository->getMembershipNo($get_member_id['member_number']);

                if ($getExistingMember) {
                    return $this->successResponse($getExistingMember, 'User already exists', 200);
                } else {
                    // Create new membership and user record
                    $create_member = $this->membershipRepository->createMembership($membersValidatedData, $usersValidatedData);

                    if ($create_member) {
                        $getExistingMember = $this->membershipRepository->getMembershipNo($get_member_id['member_number']);
                        return $this->successResponse($getExistingMember, 'Successfully added new member', 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'error' => 'Failed to create new member',
                        ], 400);
                    }
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

            $create_member = $this->membershipRepository->createMembership($membersValidatedData, $usersValidatedData);

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
