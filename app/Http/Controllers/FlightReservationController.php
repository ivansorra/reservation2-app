<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FlightReservationRequest;

use App\Services\FlightReservationServices;

class FlightReservationController extends Controller
{
    private $reservation;

    public function __construct(FlightReservationServices $reservationService)
    {
        $this->reservation = $reservationService;
    }

    public function index(Request $request)
    {
        return $this->reservation->getReservation($request);
    }

    public function show(Request $request)
    {
        if($request->has('name'))
        {
            return $this->reservation->searchUsersReservation($request);
        }
        else {
            return $this->reservation->getReservationId($request);
        }
    }


    public function store(Request $request, FlightReservationRequest $reservationReq)
    {
        return $this->reservation->createReservation($request, $reservationReq);
    }

    public function update(Request $request, FlightReservationRequest $reservationReq)
    {
        return $this->reservation->updateReservation($request, $reservationReq);
    }

    public function destroy(Request $request)
    {
        return $this->reservation->deleteReservation($request);
    }
}
