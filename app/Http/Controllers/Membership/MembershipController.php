<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;

// ----------- Laravel Request ---------------
use Illuminate\Http\Request;
// -------------------------------------------

// ------------ Custom Requests ---------------
use App\Http\Requests\MembershipRequest;
use App\Http\Requests\UserRequest;
// --------------------------------------------

// ---------- Laravel Services -------------
use App\Services\MembershipServices;
// -----------------------------------------

class MembershipController extends Controller
{
    private $member;

    public function __construct(MembershipServices $memberService)
    {
        $this->member = $memberService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->member->getMembersList($request);
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
    public function store(Request $request, MembershipRequest $memberRequest, UserRequest $userRequest)
    {
        return $this->member->createNewMember($request, $memberRequest, $userRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->member->getMemberById($request);
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
    public function update(Request $request, MembershipRequest $memberRequest)
    {
        return $this->member->updateMember($request, $memberRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->member->deleteMember($request);
    }
}
