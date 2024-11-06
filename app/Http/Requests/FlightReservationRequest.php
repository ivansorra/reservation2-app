<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightReservationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required',
            'arrival_date' => 'sometimes|required|date',
            'return_date' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
    }
}
