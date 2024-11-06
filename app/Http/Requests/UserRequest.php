<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required',
            'name' => 'sometimes|required',
            'email_address' => 'sometimes|required|email',
            'birthdate' => 'sometimes|required',
            'contact_no' => 'sometimes|required',
            'user_status' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
    }
}
