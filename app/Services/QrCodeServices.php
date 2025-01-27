<?php

namespace App\Services;

// ----------- Laravel Repositories ------------
use App\Repositories\QrCodeRepository;
// ---------------------------------------------

// ----------- Laravel Requests ----------------
use Illuminate\Http\Request;
// ---------------------------------------------

// ----------- Json Response -------------------
use Illuminate\Http\JsonResponse;
// ---------------------------------------------

// ----------- Laravel Traits ------------------
use App\Traits\ResponseTraits;
// ---------------------------------------------

class QrCodeServices
{
    use ResponseTraits;
    /**
     * Create a new class instance.
     */

    private $qrRepository;

    public function __construct(QrCodeRepository $qr_code)
    {
        $this->qrRepository = $qr_code;
    }

    public function getUserQrCodes(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            $user_qr_list = $this->qrRepository->getQrCodes($limit);

            return $this->successResponse($user_qr_list, 'Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e, 'Error', 400);
        }
    }
}
