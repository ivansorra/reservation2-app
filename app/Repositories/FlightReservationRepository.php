<?php

namespace App\Repositories;

use App\Models\FlightReservation;

use App\Interface\FlightReservationInterface;

use Carbon\Carbon;

class FlightReservationRepository implements FlightReservationInterface
{
    private $reservation;
    /**
     * Create a new class instance.
     */
    public function __construct(FlightReservation $flightReservation)
    {
        $this->reservation = $flightReservation;
    }

    public function getReservations($perPage = 10)
    {
        return $this->reservation->with('users')->paginate($perPage);
    }

    public function searchReservationByName($name)
    {
        return $this->reservation->with('users')->whereHas('users', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->get();
    }

    public function getReservation($id = null, $user_id = null)
    {
        if($user_id){
            $reservation = $this->reservation->where('user_id', $user_id)->first();
        }
        else {
            $reservation = $this->reservation->where('travel_id', $id)->first();
        }

        // return $this->reservation->where('travel_id', $id)->first();
        return $reservation;
    }

    public function createReservation(array $data)
    {
        $travel_reservation = $this->reservation->firstOrCreate([
            'user_id' => $data['user_id'],
            'arrival_date' => Carbon::parse($data['arrival_date'])->format('Y-m-d'),
            'return_date' => Carbon::parse($data['return_date'])->format('Y-m-d'),
        ]);

        return $travel_reservation;
    }

    public function updateReservation($id, $data)
    {
        $travel_reservation = $this->reservation->where(['user_id' => $id])->first();

        if (!$travel_reservation) {
            throw new \Exception('Travel reservation not found.');
        }

        $travel_reservation->update($data);

        return $travel_reservation;
    }

    public function deleteReservation($id)
    {
        $deleteReservation = $this->reservation->find($id);

        if (!$deleteReservation) {
            throw new \Exception('Travel reservation not found.');
        }

        return $deleteReservation->delete();
    }

    public function getReservationByDate($date)
    {

    }
}
