<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\UserServices;

use App\Http\Requests\UserRequest;
use App\Http\Requests\EmergencyDetailsRequest;
use App\Http\Requests\FlightReservationRequest;

class UsersController extends Controller
{
    private $users;

    public function __construct(UserServices $userService)
    {
        $this->users = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->users->getUsersList($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UserRequest $userReq, EmergencyDetailsRequest $emergencyDetailsReq, FlightReservationRequest $reservationReq)
    {
        return $this->users->createUser($request, $userReq, $emergencyDetailsReq, $reservationReq);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRequest $userReq)
    {
        return $this->users->updateUsers($request, $userReq);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->users->deleteUser($request);
    }
}
