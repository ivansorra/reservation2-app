<?php

namespace App\Traits;

trait ResponseTraits
{
    /**
     * Return a successful JSON response.
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message = '')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Return an error JSON response.
     *
     * @param \Exception $e
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($e, $message = '')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'server_response' => 'error',
            'error' => $e->getMessage()
        ]);
    }
}
