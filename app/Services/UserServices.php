<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Requests\FlightReservationRequest;
use App\Http\Requests\EmergencyDetailsRequest;

use App\Repositories\UserRepository;
use App\Repositories\MembershipRepository;
use App\Repositories\FlightReservationRepository;
use App\Repositories\EmergencyDetailsRepositories;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Traits\ResponseTraits;

class UserServices
{
    use ResponseTraits;

    private $userRepository, $members, $reservation, $emergency_details;
    /**
     * Create a new class instance.
     */
    public function __construct(UserRepository $userRepo, MembershipRepository $memberRepository, FlightReservationRepository $flightReservationRepository, EmergencyDetailsRepositories $emergencyRepository)
    {
        $this->userRepository = $userRepo;
        $this->members = $memberRepository;
        $this->reservation = $flightReservationRepository;
        $this->emergency_details = $emergencyRepository;
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

    public function createUser(Request $request, UserRequest $userReq, EmergencyDetailsRequest $emergencyDetailsRequest, FlightReservationRequest $reservationRequest)
    {
        try {
            $userValidator = $userReq->authorize($request);

            if($userValidator instanceof JsonResponse)
            {
                return $userValidator;
            }

            $reservationValidator = $reservationRequest->authorize($request);

            if($reservationValidator instanceof JsonResponse)
            {
                return $reservationValidator;
            }

            $emergencyDetailsValidator = $emergencyDetailsRequest->authorize($request);

            if($emergencyDetailsValidator instanceof JsonResponse)
            {
                return $emergencyDetailsValidator;
            }

            $userValidatedData = $userValidator->validated();
            $reservationValidatedData = $reservationValidator->validated();
            $emergencyDetailsValidatedData = $emergencyDetailsValidator->validated();

            $userValidatedData['role_id'] = $request->get('role_id');
            $userValidatedData['user_role_status'] = $request->get('user_role_status');

            if(!empty($request->get('membership_id')))
            {
                $userValidatedData['membership_id'] = $request->get('membership_id');

                $create_user = $this->userRepository->addUser($userValidatedData);

                if (!$create_user || !$create_user->id) {
                    return response()->json(['error' => 'Failed to create user or fetch user ID'], 500);
                }

                $reservationValidatedData['user_id'] = $create_user->id;
                $emergencyDetailsValidatedData['user_id'] = $create_user->id;

                $create_reservation = $this->reservation->createReservation($reservationValidatedData);
                $create_contact_emergency = $this->emergency_details->createEmergencyDetail($emergencyDetailsValidatedData);

                return $this->successResponse([
                    'user' => $create_user,
                    'reservation' => $create_reservation,
                    'emergency_details' => $create_contact_emergency,
                ], 'Successfully created user');
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
