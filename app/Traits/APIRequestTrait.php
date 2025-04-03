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

            // dd($response->status());

            if($response->status() === 503)
            {
                return response()->json([
                    "success" => false,
                    "message" => 'There is a problem connecting to the server.',
                    "server_response" => 'error'
                ], 503);
            }

            $results = [];

            // dd($response);
            if ($response->successful() && $response->json()['msg'] != []) {
                $json_response = $response->json()['msg'][0];

                $results = [
                    "member_number" => $json_response['memberNo'],
                    "member_name" => $json_response['memberName'],
                    "member_type" => $json_response['memType'],
                    "activation_date" => $json_response['ActivDt'],
                    "member_email" => $json_response['email'],
                    "address" => $json_response['address'][0],
                    "phone_number" =>  ltrim(intval($json_response['phones'][0]), '+'),
                    "birthdate" => $json_response['birthDate'],
                    "confirmation_no" => $json_response['nextConfNo'],
                    "arrival_date" => $json_response['nextArrDt'],
                    "return_date" => $json_response['nextDepDt'],
                    "relation" => $json_response['relation']
                ];

                // return $results;
                return $this->successResponse($results, 'Successfully fetched data', $response->status());
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
