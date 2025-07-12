<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Set Semula Kata Laluan Anda - MOTAC Training & Management System</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }

        .container-header {
            text-align: center;
            background-color: #2F8AD0;
            color: white;
            padding: 5px;
            font-weight: 600;
        }

        .content {
            font-size: 16px;
            color: #444;
            line-height: 1.7;
            padding: 40px 30px;
        }

        .content p {
            margin-bottom: 1.5em;
        }

        .header {
            text-align: center;
            margin: 0px;
            font-size: 28px;
            font-weight: 500;
            color: #333;
        }

        .btn-verify {
            display: inline-block;
            background-color: #2F8AD0;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            width: 50%;
            margin-top: 25px;
            border-radius: 5px;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        @media screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                margin: 0 auto;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .container-header {
                border-radius: 0;
                padding: 20px 15px;
            }

            .content {
                padding: 25px 20px;
            }

            .btn-verify {
                padding: 10px 20px;
                font-size: 15px;
                width: 70%;
            }
        }
    </style>
</head>

<body style="background-color: #f0f4f8; padding: 8px;">
    <div class="container">
        <div class="container-header">
            <!-- This header can be used for a logo or a small title if needed, currently empty -->
        </div>
        <div class="content">
            <div class="header">Tetapan Semula Kata Laluan Sistem {{ config('app.name') }}</div>
            <hr style="margin-top: 20px; margin-bottom: 20px; border: none; border-top: 1px solid #eee;">

            <p>YBhg. Datuk / Dato’ / YBrs. Dr. / Ts. / Tuan / Puan,</p>

            <p>
                Untuk menetapkan semula kata laluan akaun YBhg. Datuk / Dato’ / YBrs. Dr. / Ts. / Tuan / Puan, sila klik
                pautan di bawah:
            </p>

            <p style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
                @if (!empty($url))
                <a href="{{ $url }}" target="_blank"
                    style="display: inline-block; background-color: #2F8AD0; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-weight: 600; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                    class="btn-verify">Set Semula Kata Laluan</a>
                @else
                <span style="color: red;"><em>Pautan tidak tersedia.</em></span>
                @endif
            </p>

            <p>
                <strong>Nota:</strong> Pautan ini hanya sah dalam tempoh <strong>60 minit</strong> dari masa e-mel
                ini dihantar.
            </p>

            <p>
                Sekiranya YBhg. Datuk / Dato’ / YBrs. Dr. / Ts. / Tuan / Puan tidak membuat permintaan ini, sila abaikan
                emel ini. Tiada sebarang tindakan akan diambil tanpa pengesahan daripada pihak YBhg. Datuk / Dato’ /
                YBrs. Dr. / Ts. / Tuan / Puan.
            </p>

            <p>Sekian, terima kasih.</p>

            <p>
                Pentadbir Sistem<br>
                Bahagian Pengurusan Maklumat<br>
                Kementerian Pelancongan, Seni dan Budaya
            </p>

            <hr style="width: 25%; border: none; border-top: 1px solid #eee; margin: 0 auto 20px auto;">

            <p style="text-align: center; font-size: 14px; color: #777;">
                <em>Jika anda tidak membuat permintaan untuk menetapkan semula kata laluan, sila abaikan emel ini.</em>
            </p>
        </div>
    </div>
</body>

</html>