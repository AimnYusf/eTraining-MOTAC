<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Your QR Code</title>
    <style>
        /* Optional: Add some basic styling for better email presentation */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            /* Helps center the image if needed */
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Dear {{ $mailData['userName'] ?? 'User' }},</p>
        <p>Here is your QR code related to your application. Please keep it safe.</p>
        {{-- Directly embed the base64 encoded QR code --}}
        <img src="data:image/png;base64,{{ $mailData['qr'] }}" alt="QR Code" width="300">
        <p>If you have any questions, feel free to contact us.</p>
        <p>Sincerely,</p>
        <p>Your Application Team</p>
    </div>
</body>

</html>