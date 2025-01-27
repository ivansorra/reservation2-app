<?php

namespace App\Interface;

interface QrCodeInterface
{
    public function getQrCodes();
    public function getQrCode($id);
    public function generateQrCode($data);
    public function updateQrCode($id, $url);
    public function deleteQrCode($id);
}
