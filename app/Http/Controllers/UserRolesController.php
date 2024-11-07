<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserRolesRequest;

use App\Services\RolesServices;

class UserRolesController extends Controller
{
    public $userroles;
    public $requests;

    public function __construct(RolesServices $roles){
        $this->userroles = $roles;
    }

    public function index(Request $request)
    {
        return $this->userroles->getUserRoles($request);
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
    public function store(Request $request, UserRolesRequest $userroleRequest)
    {
        return $this->userroles->createRole($request, $userroleRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if($request->has('role_id'))
        {
           return $this->userroles->getRoleById($request);
        }
        elseif($request->has('role_name'))
        {
           return $this->userroles->getRoleName($request);
        }
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
    public function update(Request $request, UserRolesRequest $validate)
    {
        return $this->userroles->updateRole($request, $validate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->userroles->deleteRole($request);
    }
}
