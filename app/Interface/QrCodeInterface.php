<?php

namespace App\Interface;

interface QrCodeInterface
{
    public function getQrCodes();
    public function getQrCode($id);
    public function generateQrCode($data);
    public function deleteQrCode($id);
}
