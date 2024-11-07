<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmergencyDetailsRequest;

use App\Services\EmergencyDetailsServices;

class EmergencyDetailsController extends Controller
{
    private $emergencyDetails;

    public function __construct(EmergencyDetailsServices $emergencyDetailsService)
    {
        $this->emergencyDetails = $emergencyDetailsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->emergencyDetails->getEmergencyDetails($request);
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
    public function store(Request $request, EmergencyDetailsRequest $emergencyDetailsReq)
    {
        return $this->emergencyDetails->createEmergencyDetail($request, $emergencyDetailsReq);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->emergencyDetails->getSingleEmergencyDetail($request);
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
    public function update(Request $request, EmergencyDetailsRequest $emergencyDetailsReq)
    {
        return $this->emergencyDetails->updateEmergencyDetail($request, $emergencyDetailsReq);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->emergencyDetails->deleteEmergencyDetail($request);
    }
}
