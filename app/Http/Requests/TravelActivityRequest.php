<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TravelActivityRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required',
            'travel_id' => 'sometimes|required',
            'activity_name' => 'sometimes|required',
            'location' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
    }
}
