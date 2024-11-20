<?php

namespace App\Traits;

use App\Traits\ResponseTraits;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait APIRequestTrait
{
    use ResponseTraits;

    public function get_intimus_members($request)
    {
        try {
            $api_key = env('INTIMUS_API_KEY_LIVE');

            $response = Http::withHeaders([
                'X-Api-Key' => $api_key,
                'Accept' => 'application/json',
            ])->get(env('INTIMUS_API_URL_LIVE') . "getmemberdet", [
                'memid' => $request->get('memid'),
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return ResponseTraits::successResponse($response->body(), 'Successfully fetched data', $response->status());
        }
        catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
