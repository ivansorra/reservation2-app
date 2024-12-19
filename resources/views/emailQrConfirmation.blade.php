<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balesin QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
        }
        .qr-container {
            text-align: center;
            margin: 20px 0;
        }
        .qr-container img {
            width: 150px;
            height: 150px;
        }
        p {
            font-size: 16px;
        }
        a {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- <h1>QR Code Reservation Confirmation</h1> --}}
        <p>Dear Mr/Ms. {{ $user_name }},</p>
        <p>Good day! This is your unique Balesin Island Club QR Code.</p>
        <div class="qr-container">
            {{-- <img src="{{$qrCodeUrl}}" alt="QR Code" style="width: 150px; height: 150px;" /> --}}
            {!! $qrCodeUrl !!}
        </div>
        <p><b>A photo of the QR Code must be saved on your mobile phone (e.g. Photo Gallery, Viber, Whats App) for scanning by Alphaland personnel upon flight check-in.</b></p>
        <p><b>Each passenger including infants must have a separate QR code.</b></p>
        <dl>
            <dt>The following must be presented upon flight check-in:</dt>
            <dd>- photo of your QR Code</dd>
            <dd>- valid photo ID</dd>
            <dd>- birth certificate for infants</dd>
            <dd>- medical certificate for expectant mothers who are between 24-32 weeks pregnant</dd>
        </dl>
        <p>
            Please note that this QR code is valid from
            <b>{{ \Carbon\Carbon::parse($date_from)->format('m-d-Y') }}
            to {{ \Carbon\Carbon::parse($date_to)->format('m-d-Y') }}</b>.
        </p>
        <p>Thank you and we look forward to having you in Balesin Island Club.</p>
    </div>
</body>
</html>
