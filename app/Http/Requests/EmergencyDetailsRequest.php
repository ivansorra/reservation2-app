<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmergencyDetailsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required',
            'emergency_contact_name' => 'sometimes|required',
            'emergency_contact_no' => 'sometimes|required|numeric',
            'emergency_contact_address' => 'sometimes|required',
            'relationship' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
    }
}
