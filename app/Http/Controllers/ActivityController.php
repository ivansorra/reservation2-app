<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TravelActivityRequest;

use App\Services\ActivityServices;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $activity;

    public function __construct(ActivityServices $activityService)
    {
        $this->activity = $activityService;
    }

    public function index(Request $request)
    {
        return $this->activity->getAllTravels($request);
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
    public function store(Request $request, TravelActivityRequest $travelreq)
    {
        return $this->activity->createTravelActivity($request, $travelreq);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->activity->getTravelActivity($request);
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
    public function update(Request $request, TravelActivityRequest $travelreq)
    {
        return $this->activity->updateTravelActivity($request, $travelreq);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->activity->deleteTravelActivity($request);
    }
}
