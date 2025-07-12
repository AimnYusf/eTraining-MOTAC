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
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        .email-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }

        .email-header-banner {
            text-align: center;
            background: linear-gradient(to bottom, #B53939 10px, #D64545 10px);
            color: white;
            padding-top: 30px;
            padding-bottom: 20px;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 28px;
            font-weight: 500;
        }

        .email-content {
            font-size: 16px;
            color: #444;
            line-height: 1.7;
            padding: 40px 30px;
        }

        .email-content p {
            margin-bottom: 1.5em;
        }

        .info-table-wrapper {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 90%;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 15px;
            color: #555;
        }

        .info-table td:first-child {
            width: 30%;
            font-weight: 600;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                max-width: 100%;
                margin: 0 auto;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .email-header-banner {
                padding: 20px 15px;
            }

            /* Adjust for mobile to maintain the top bar */
            .email-header-banner::before {
                margin-top: -20px;
                margin-bottom: 15px;
            }

            .email-content {
                padding: 25px 20px;
            }

            .info-table-wrapper {
                padding: 15px;
                margin: 15px auto;
            }

            .info-table td {
                display: block;
                width: 100%;
                padding: 5px 0;
            }

            .info-table td:first-child {
                font-weight: bold;
                width: 100%;
            }
        }
    </style>
</head>

<body style="background-color: #f0f4f8; padding: 8px;">
    <div class="email-container">
        <div class="email-header-banner">
            Makluman Permohonan Kursus Tidak Berjaya – {{ strtoupper($kursus->kur_nama ?? '[NAMA KURSUS]')}}
        </div>
        <div class="email-content">
            <p>Tuan/Puan,</p>

            <p>Dimaklumkan bahawa permohonan Tuan/Puan untuk menghadiri
                <strong>{{ $kursus->kur_nama ?? '[NAMA KURSUS]' }}</strong>
                pada tarikh
                <strong>
                    {{ isset($kursus) && $kursus->kur_tkhmula
    ? \Carbon\Carbon::parse($kursus->kur_tkhmula)->translatedFormat('d F Y')
    : '[TARIKH KURSUS]' 
    }}
                </strong>
                tidak berjaya atas
                sebab-sebab berikut:
            </p>
            <ul>
                <li>[Contoh sebab, jika ingin dinyatakan: Tempat telah penuh / Tidak memenuhi kriteria pemilihan /
                    Kursus dibatalkan]</li>
            </ul>

            <p>Walau bagaimanapun, Tuan/Puan boleh membuat permohonan semula sekiranya kursus ini ditawarkan semula pada
                masa akan datang atau memilih kursus lain yang bersesuaian melalui Sistem {{ config('app.name') }}.</p>
            <p>Sebarang pertanyaan lanjut boleh diajukan kepada penyelaras/ urus setia kursus di [alamat e-mel atau
                nombor telefon].</p>
            <p>Segala kerjasama dan perhatian Tuan/Puan amat dihargai.</p>

            <p>Sekian, terima kasih.</p>
            <p style="margin: 0;"><strong>Penyelaras Kursus</strong></p>
            <p style="margin: 0;">Kementerian Pelancongan, Seni dan Budaya</p>

            <p style="font-size: 12px; color: #999; text-align: center; margin-top: 40px;">
                <em>Nota : Emel ini dijana secara automatik, sila jangan balas e-mel ini.</em>
            </p>
        </div>
    </div>
</body>

</html>