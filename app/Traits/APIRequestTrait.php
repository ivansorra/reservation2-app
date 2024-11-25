<?php

namespace App\Traits;

use Illuminate\Http\Request; // Import the Request class
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait APIRequestTrait
{
    use ResponseTraits;

    public function get_intimus_members(Request $request)
    {
        try {
            $api_key = env('INTIMUS_API_KEY_TRAINING'); // API key from environment file
            $api_url = env('INTIMUS_API_URL_TRAINING'); // Base API URL from environment file

            // Perform the HTTP GET request
            $response = Http::withHeaders([
                'Authorization' => $api_key,
                // 'Accept' => 'application/json',
            ])->get($api_url . "/getmemberdet", [
                'memid' => $request->get('membership_no'), // Query parameter
            ]);

            $results = [];

            // dd($response);
            if ($response->successful() && $response->json()['msg'] != []) {
                $json_response = $response->json()['msg'][0];

                $results = [
                    "member_number" => $json_response['memberNo'],
                    "member_name" => $json_response['memberName'],
                    "member_type" => $json_response['memType'],
                    "activation_date" => $json_response['ActivDt'],
                ];

                return $results;
                // return $this->successResponse($response->json()['msg'][0], 'Successfully fetched data', $response->status());
            }
            else {
                return response()->json([
                    "success" => false,
                    "message" => 'Failed to fetch member details',
                    "server_response" => 'error'
                ], 500);
            }

            // Handle non-successful responses
            // return $this->errorResponse('Failed to fetch member details', $response->status(), $response->json());
        } catch (\Exception $e) {
            // Catch and handle exceptions
            throw new HttpException(500, $e->getMessage());
        }
    }
}
