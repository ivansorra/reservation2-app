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
// ---------------------------------------------

class MembershipServices
{
    use ResponseTraits;

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

            return $this->successResponse($members_list, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function getMemberById(Request $request)
    {
        try {
            $member_id = $request->get('membership_no');

            $get_member_id = $this->membershipRepository->getMembershipNo($member_id);

            if($get_member_id)
            {
                return $this->successResponse($get_member_id, 'Sucessfully retrieved membership');
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'Membership not found',
                    'server_response' => 'error'
                ]);
            }

        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
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

            return $this->successResponse($create_member, 'Success');

        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
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

            return $this->successResponse($update_member, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }
    public function deleteMember(Request $request)
    {
        try {
            $member_id = $request->get('member_id');
            $delete_member = $this->membershipRepository->deleteMembership($member_id);
            return $this->successResponse(null, 'Membership and associated users deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

}
