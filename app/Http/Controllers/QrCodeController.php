<?php

namespace App\Http\Controllers;

use App\Models\FlightReservation;
use Illuminate\Http\Request;
use App\Models\QrCodes;

use App\Services\QrCodeServices;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $qrCode;

    public function __construct(QrCodeServices $qrCodeServices)
    {
        $this->qrCode = $qrCodeServices;
    }
    public function index(Request $request)
    {
        return $this->qrCode->getUserQrCodes($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $qr_code = QrCodes::find($id);

            if (!$qr_code) {
                return response()->json(['message' => 'QR code not found.'], 404);
            }

            $reservation = FlightReservation::where('travel_id', $qr_code->travel_id)->first();

            $decoded_res = json_decode($qr_code->qr_content, true);
            $decoded_res['user_id'] = $reservation->user_id;
            $decoded_res['travel_id'] = $qr_code->travel_id;
            $decoded_res['arrival_date'] = $reservation->arrival_date;
            $decoded_res['departure_date'] = $reservation->return_date;
            // dd($decoded_res);
            // Return the view with the QR code data
            if($decoded_res['departure_date'] < now())
            {
                $qr_code->update([
                    'is_active' => 0
                ]);
            }

            return view('qrResponseView', ['qr_code' => $decoded_res]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json([
                'message' => 'An error occurred while retrieving the QR code.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
