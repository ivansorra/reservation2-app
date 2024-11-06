<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRolesRequest
{
    public function authorize(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'role_id' => 'sometimes|required',
            'role_name' => 'sometimes|required',
            'status' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
     }
}
