<?php

namespace App\Services;

use App\Repositories\FlightReservationRepository;

// ----------- Laravel Requests ----------------
use App\Http\Requests\FlightReservationRequest;
use Illuminate\Http\Request;
// ---------------------------------------------

// ----------- Json Response -------------------
use Illuminate\Http\JsonResponse;
// ---------------------------------------------

// ----------- Laravel Traits ------------------
use App\Traits\ResponseTraits;
// ---------------------------------------------

class FlightReservationServices
{
    use ResponseTraits;

    private $reservation;
    /**
     * Create a new class instance.
     */
    public function __construct(FlightReservationRepository $flightReservation)
    {
        $this->reservation = $flightReservation;
    }

    public function getReservation(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            $reservations = $this->reservation->getReservations($limit);

            return $this->successResponse($reservations, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function getReservationId(Request $request)
    {
        try {
            $reservation_id = $request->get('reservation_id');

            $get_reservations = $this->reservation->getReservation($reservation_id);

            return $this->successResponse($get_reservations, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function createReservation(Request $request, FlightReservationRequest $reservationReq){
        try {
            $validate = $reservationReq->authorize($request);

            if ($validate instanceof JsonResponse) {
                return $validate;
            }

            $validatedData = $validate->validated();

            $new_reservation = $this->reservation->createReservation($validatedData);

            return $this->successResponse($new_reservation, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function updateReservation(Request $request, FlightReservationRequest $reservationReq){
        try {
            $validate = $reservationReq->authorize($request);

            if ($validate instanceof JsonResponse) {
                return $validate;
            }

            $validatedData = $validate->validated();
            $reservation_id = $request->get('reservation_id');

            $updated_reservation = $this->reservation->updateReservation($reservation_id, $validatedData);

            return $this->successResponse($updated_reservation, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }

    public function deleteReservation(Request $request){
        try {
            $reservation_id = $request->get('reservation_id');

            $delete_reservation = $this->reservation->deleteReservation($reservation_id);

            return $this->successResponse($delete_reservation, 'Success');
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error');
        }
    }
}
