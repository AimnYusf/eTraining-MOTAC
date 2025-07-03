<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Application Approved!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px 0;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #666;
            margin-top: 20px;
        }

        .highlight {
            font-weight: bold;
            color: #007bff;
        }

        .qr-code-image {
            max-width: 200px;
            height: auto;
            border: 1px solid #eee;
            padding: 5px;
            margin-top: 20px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Permohonan Anda Berjaya!</h2>
        </div>
        <div class="content">
            <p>Tuan/Puan,</p>
            <p>Untuk rekod kehadiran anda semasa kursus, sila gunakan **kod QR** di bawah:</p>

            @if (isset($qrCodeFilePath) && file_exists($qrCodeFilePath))
                <img src="{{ $message->embed($qrCodeFilePath) }}" alt="Kod QR Kehadiran" class="qr-code-image">
            @else
                <p>Kod QR tidak dapat dipaparkan. Sila hubungi urusetia kursus.</p>
            @endif

            <p>Sila pastikan anda menyimpan e-mel ini dan bersedia menunjukkan kod QR anda semasa pendaftaran atau
                apabila diminta.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Nama Aplikasi Anda. Hak Cipta Terpelihara.</p>
        </div>
    </div>
</body>

</html>