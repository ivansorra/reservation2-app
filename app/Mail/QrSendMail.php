<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QrSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user_role;
    public $user_name;
    public $date_from;
    public $date_to;
    public $qr_id;
    public $qr_code;

    public function __construct($user_role, $user_name, $visit_from, $visit_to, $qr_id, $qr_code)
    {
        $this->user_role = $user_role;
        $this->user_name = $user_name;
        $this->date_from = $visit_from;
        $this->date_to = $visit_to;
        $this->qr_id = $qr_id;
        $this->qr_code = $qr_code;
    }

    public function build()
    {
        return $this->subject('Balesin Island Club QR Code')->view('emailQrConfirmation')->with(
            [
                'user_role' => $this->user_role,
                'user_name' => $this->user_name,
                'date_from' => $this->date_from,
                'date_to' => $this->date_to,
                'qr_id' => $this->qr_id,
                'qrCodeUrl' => $this->qr_code
            ]
        );
    }
}
