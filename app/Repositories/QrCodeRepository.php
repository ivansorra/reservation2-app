<?php

namespace App\Repositories;


// --------------- Laravel Models ------------------
use App\Models\QrCodes;
//--------------------------------------------------

// --------------- Laravel Interfaces --------------
use App\Interface\QrCodeInterface;
// -------------------------------------------------

class QrCodeRepository implements QrCodeInterface
{
    /**
     * Create a new class instance.
     */

    private $qrcode;

    public function __construct(QrCodes $qrcodes)
    {
        $this->qrcode = $qrcodes;
    }

    public function getQrCodes($perPage = 10)
    {
        return $this->qrcode->with('travel')->paginate($perPage);
    }
    public function getQrCode($id)
    {
        return $this->qrcode->find($id);
    }
    public function generateQrCode($data)
    {
        return $this->qrcode->create($data);
    }
    public function updateQrCode($id, $url)
    {
        return $this->qrcode->where('qr_id', $id)->update(['qr_url' => $url]);
    }
    public function deleteQrCode($id)
    {
        return $this->qrcode->find($id)->delete();
    }
}
