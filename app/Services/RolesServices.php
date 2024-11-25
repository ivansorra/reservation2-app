<?php

namespace App\Services;

use App\Repositories\RolesRepository;
use App\Http\Requests\UserRolesRequest;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RolesServices
{
    use ResponseTraits;
    private $rolesRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(RolesRepository $rolesRepo)
    {
        $this->rolesRepository = $rolesRepo;
    }

    public function getUserRoles(Request $request)
    {
        try
        {
            $limit = $request->get('limit') ?? 10;

            $getRoles = $this->rolesRepository->getRoles($limit);

            return response()->json([
                'success' => true,
                'data' => $getRoles,
                'server_response' => 'ok'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
               'success' => false,
               'message' => $e->getMessage(),
               'server_response' => 'error'
            ]);
        }
    }

    public function getRoleById(Request $request)
    {
        try {
            $role_id = $request->get('role_id');

            $get_roles = $this->rolesRepository->getRole($role_id);

            return response()->json([
                'success' => true,
                'data' => $get_roles,
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
               'success' => false,
               'message' => $e->getMessage(),
               'server_response' => 'error'
            ]);
        }
    }

    public function getRoleName(Request $request)
    {
        try {
            $role_name = $request->get('role_name');
            $get_role = $this->rolesRepository->getRoleByName($role_name);
            return $this->successResponse($get_role, 'Successfully retrieved role', 200);
        } catch (\Exception $e)
        {
            return $this->errorResponse($e, 'Error retrieving role', 400);
        }
    }

    public function createRole(Request $request, UserRolesRequest $userroleRequest)
    {
        try {
            $validator = $userroleRequest->authorize($request);

            if ($validator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $validator;
            }

            $validatedData = $validator->validated();

            $validatedData['status'] = $validatedData['status'] == 'active' ? true : false;

            $create_role = $this->rolesRepository->createRoles($validatedData);

            return response()->json([
                'success' => true,
                'server_response' => 'ok'
            ]);
        } catch(\Exception $e)
        {
            return response()->json([
               'success' => false,
               'message' => $e->getMessage(),
               'server_response' => 'error'
            ]);
        }
    }

    public function updateRole(Request $request, UserRolesRequest $userroleRequest)
    {
        try {
            $validator = $userroleRequest->authorize($request);

            if ($validator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $validator;
            }

            $validatedData = $validator->validated();

            $validatedData['status'] = $validatedData['status'] == 'active' ? true : false;

            $update_role = $this->rolesRepository->updateRoles($validatedData['role_id'], $validatedData);

            return response()->json([
                'success' => true,
                'server_response' => 'ok'
            ]);
        } catch(\Exception $e) {
            return response()->json([
               'success' => false,
               'message' => $e->getMessage(),
               'server_response' => 'error'
            ]);
        }
    }

    public function deleteRole(Request $request)
    {
        try {
            $delete_role = $this->rolesRepository->deleteRoles($request->get('role_id'));

            return response()->json([
               'success' => true,
               'server_response' => 'ok'
            ]);

        } catch(\Exception $e) {
            return response()->json([
               'success' => false,
               'message' => $e->getMessage(),
               'server_response' => 'error'
            ]);
        }
    }
}
