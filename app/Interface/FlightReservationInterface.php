<?php

namespace App\Interface;

interface FlightReservationInterface
{
    public function getReservations();
    public function getReservation($id);
    public function createReservation(array $data);
    public function updateReservation($id, $data);
    public function deleteReservation($id);
    public function getReservationByDate($date);
}
