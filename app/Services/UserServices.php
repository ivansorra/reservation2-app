<?php

namespace App\Services;

// --------------- Requests -----------------------
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FlightReservationRequest;
use App\Http\Requests\EmergencyDetailsRequest;
// ------------------------------------------------

// ------------------ Repositories ----------------
use App\Repositories\UserRepository;
use App\Repositories\MembershipRepository;
use App\Repositories\FlightReservationRepository;
use App\Repositories\EmergencyDetailsRepositories;
use App\Repositories\RolesRepository;
use App\Repositories\QrCodeRepository;
// ------------------------------------------------

// ------------------ Mailers ------------------------
use Illuminate\Support\Facades\Mail;
use App\Mail\QrSendMail;

// ------------------- JSON Response ------------------
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTraits;
// ----------------------------------------------------

// ------------------- Storage ----------------------
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
// --------------------------------------------------

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Carbon\Carbon;

class UserServices
{
    use ResponseTraits;

    private $userRepository, $members, $reservation, $emergency_details, $qr_code, $rolesRepo;
    /**
     * Create a new class instance.
     */
    public function __construct(UserRepository $userRepo, MembershipRepository $memberRepository, FlightReservationRepository $flightReservationRepository, EmergencyDetailsRepositories $emergencyRepository, QrCodeRepository $qrCodeRepository, RolesRepository $roleRepository)
    {
        $this->userRepository = $userRepo;
        $this->members = $memberRepository;
        $this->reservation = $flightReservationRepository;
        $this->emergency_details = $emergencyRepository;
        $this->rolesRepo = $roleRepository;
        $this->qr_code = $qrCodeRepository;
    }

    public function getUsersList(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            $usersList = $this->userRepository->getUsers($limit);

            return $this->successResponse($usersList, 'Successfully retrieved all users', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }

    public function getSingleUser(Request $request)
    {
        try {
            $user_id = $request->get('user_id');

            $user = $this->userRepository->getUserById($user_id);

            return $this->successResponse($user, 'Successfully retrieved user', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error fetching users', 400);
        }
    }

    public function createUser(
        Request $request,
        UserRequest $userReq,
        EmergencyDetailsRequest $emergencyDetailsRequest,
        FlightReservationRequest $reservationRequest
    ) {
        try {
            // dd($request->all());
            // Validate UserRequest
            $userValidator = $userReq->authorize($request);
            if ($userValidator instanceof JsonResponse) {
                return $userValidator;
            }

            // Validate FlightReservationRequest
            $reservationValidator = $reservationRequest->authorize($request);
            if ($reservationValidator instanceof JsonResponse) {
                return $reservationValidator;
            }

            // Validate EmergencyDetailsRequest
            $emergencyDetailsValidator = $emergencyDetailsRequest->authorize($request);
            if ($emergencyDetailsValidator instanceof JsonResponse) {
                return $emergencyDetailsValidator;
            }

            // Extract validated data
            $userValidatedData = $userValidator->validated();
            $reservationValidatedData = $reservationValidator->validated();
            $emergencyDetailsValidatedData = $emergencyDetailsValidator->validated();

            // Add role data
            $userValidatedData['role_id'] = $request->get('role_id');
            $userValidatedData['user_role_status'] = $request->get('user_role_status');

            $role_data = $this->rolesRepo->getRole($request->get('role_id'));

            // Check if Membership ID exists
            $membershipId = $request->get('membership_id');

            if (empty($membershipId)) {
                return response()->json([
                    'success' => false,
                    'messaage' => 'Membership ID does not exist',
                400]);
            }

            $userValidatedData['membership_id'] = $membershipId;

            $user_id = null;

            // dd($userValidatedData);
            $memberExists = $this->userRepository->getMemberUserId($membershipId);
            if (!$memberExists) {
                $create_user = $this->userRepository->addUser($userValidatedData);

                if (!$create_user || !$create_user->user_id) {
                    return response()->json(['error' => 'Failed to create user or fetch user ID'], 500);
                }

                $user_id = $create_user->id;
            } else {
                $user_exists = $this->userRepository->getUsersByName($request->get('name'));

                if(!$user_exists)
                {
                    $create_user = $this->userRepository->addUser($userValidatedData);
                }
                else {
                    $userValidatedData['birthdate'] = Carbon::parse($userValidatedData['birthdate'])->format('Y-m-d');
                    // $create_user = $memberExists;
                    $update_user = $this->userRepository->updateUser($user_exists->user_id, $userValidatedData);
                    $create_user = $update_user;
                }

                // dd($create_user);

                $user_id = $create_user->user_id;
            }

            $reservationValidatedData['user_id'] = $user_id;
            $emergencyDetailsValidatedData['user_id'] = $user_id;

            // if($request->has('travel_id') && $request->get('travel_id') === null)
            // {
            //     $create_reservation = $this->reservation->createReservation($reservationValidatedData);
            // }
            // else {
            //     $travel_id = $request->get('travel_id');
            //     $create_reservation = $this->reservation->getReservation($travel_id);

            //     if($create_reservation)
            //     {
            //         $update_flight_dates = $this->reservation->updateReservation($user_id, $reservationValidatedData);
            //     }
            // }

            if($request->has('travel_id') && $request->get('travel_id') !== null)
            {
                $travel_id = $request->get('travel_id');
                $create_reservation = $this->reservation->getReservation($travel_id);

                if($create_reservation)
                {
                    $update_flight_dates = $this->reservation->updateReservation($user_id, $reservationValidatedData);
                }
            }
            else {
                $create_reservation = $this->reservation->createReservation($reservationValidatedData);
            }

            if($emergencyDetailsValidatedData != [])
            {
                $emergencyDatas = [
                    'name' => $emergencyDetailsValidatedData['emergency_contact_name'],
                    'contact_no' => $emergencyDetailsValidatedData['emergency_contact_no'],
                    'address' => $emergencyDetailsValidatedData['emergency_contact_address'],
                    'relationship' => $emergencyDetailsValidatedData['relationship'],
                ];

                $contact_emergency = $this->emergency_details->updateEmergencyDetail($user_id, $emergencyDatas);
            }
            else {
                $contact_emergency = $this->emergency_details->createEmergencyDetail($emergencyDetailsValidatedData);
            }

            // Serialize the QR content into a JSON string
            $qr_content_data = json_encode([
                'name' => $create_user->name,
                'role' => $userValidatedData['role_id'],
                'email_address' => $create_user->email_address,
                'birthdate' => $create_user->birthdate,
                'contact_no' => $create_user->contact_no,
                'user_status' => $create_user->user_status == 1 ? 'active' : 'inactive',
            ]);

            $qr_code_data = [
                'user_id' => $user_id,
                'travel_id' => $create_reservation->travel_id,
                'qr_content' => $qr_content_data, // Use the serialized content
                'qr_expiration_start' => $reservationValidatedData['arrival_date'],
                'qr_expiration_end' => $reservationValidatedData['return_date'],
                'is_active' => true,
            ];

            $create_qr = $this->qr_code->generateQrCode($qr_code_data);

            $qr_content = url('/qr/show/'. $create_qr->qr_id);

            // ------------------------------------------------------------------------------
            $qrCodeBinary = QrCode::format('png')->size(200)->generate($qr_content);
            $qrCodeBase64 = base64_encode($qrCodeBinary);

            $duration = isset($reservationValidatedData['return_date'])
                ? Carbon::parse($reservationValidatedData['arrival_date'])->toFormattedDateString() . ' to ' . Carbon::parse($reservationValidatedData['return_date'])->toFormattedDateString()
                : Carbon::parse($reservationValidatedData['arrival_date'])->toFormattedDateString();

            $filename = $create_user->name . '-' . $duration . '.png';
            $qrPath = 'qr_codes/' . $filename;

            $s3Client = new S3Client([
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
                'http' => [
                    'verify' => false // Disable SSL certificate verification (for debugging only)
                ]
            ]);

            // Upload QR code image to S3
            try {
                $result = $s3Client->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => $qrPath,
                    'Body'   => $qrCodeBinary,
                    'ContentType' => 'image/png',
                ]);

                $qrPublicUrl = $result['ObjectURL'];

            } catch (AwsException $e) {
                dd('Error uploading to S3: ' . $e->getMessage());
            }

            if($request->has('alternate_email'))
            {
                $create_user->email_address = $request->get('alternate_email');
            }

            Mail::to($create_user->email_address)->send(new QrSendMail(
                $role_data['role_name'],
                $create_user->name,
                $create_reservation->arrival_date ?: $update_flight_dates->arrival_date,
                $create_reservation->return_date ?: $update_flight_dates->return_date,
                $create_qr->qr_id,
                $qrPublicUrl
            ));

            return $this->successResponse([
                'user' => $create_user,
                'email_address' => $create_user->email_address,
                'reservation' => $create_reservation ?: $update_flight_dates,
                'emergency_details' => $contact_emergency,
            ], 'Successfully created user', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
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

            return $this->successResponse($update_user, 'Successfully updated user', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error updating user', 400);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $user_id = $request->get('user_id');

            $delete_user = $this->userRepository->deleteUser($user_id);

            return $this->successResponse($delete_user, 'Successfully deleted user', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error deleting user', 400);
        }
    }
}
