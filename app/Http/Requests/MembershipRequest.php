<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'membership_id' => 'sometimes|required',
            'membership_no' => 'sometimes|required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
    }
}
