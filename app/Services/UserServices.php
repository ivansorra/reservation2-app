<?php

namespace App\Services;

use App\Http\Requests\UserRequest;

use App\Repositories\UserRepository;
use App\Repositories\MembershipRepository;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Traits\ResponseTraits;

class UserServices
{
    use ResponseTraits;

    private $userRepository, $members;
    /**
     * Create a new class instance.
     */
    public function __construct(UserRepository $userRepo, MembershipRepository $memberRepository)
    {
        $this->userRepository = $userRepo;
        $this->members = $memberRepository;
    }

    public function getUsersList(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            $usersList = $this->userRepository->getUsers($limit);

            return $this->successResponse($usersList, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function getSingleUser(Request $request)
    {
        try {
            $user_id = $request->get('user_id');

            $user = $this->userRepository->getUserById($user_id);

            return $this->successResponse($user, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function createUser(Request $request, UserRequest $userReq)
    {
        try {
            $userValidator = $userReq->authorize($request);

            if($userValidator instanceof JsonResponse)
            {
                return $userValidator;
            }

            $userValidatedData = $userValidator->validated();

            $userValidatedData['role_id'] = $request->get('role_id');
            $userValidatedData['user_role_status'] = $request->get('user_role_status');

            if(!empty($request->get('membership_id')))
            {
                $userValidatedData['membership_id'] = $request->get('membership_id');

                $create_user = $this->userRepository->addUser($userValidatedData);

                return $this->successResponse($create_user, 'Successfully created user');
            }
            else {
                return $this->errorResponse('Membership ID is required', 'Membership ID does not exist');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function updateUsers(Request $request, UserRequest $userReq)
    {
        try {
            $userValidator = $userReq->authorize($request);

            if($userValidator instanceof JsonResponse)
            {
                return $userValidator;
            }

            $userValidatedData = $userValidator->validated();

            $update_user = $this->userRepository->updateUser($userValidatedData['user_id'],$userValidatedData);

            return $this->successResponse($update_user, 'Successfully updated');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $user_id = $request->get('user_id');

            $delete_user = $this->userRepository->deleteUser($user_id);

            return $this->successResponse($delete_user, 'Successfully deleted');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }
}
