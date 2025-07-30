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
            background: linear-gradient(to bottom, #03713B 10px, #04AA56 10px);
            /* background-color: #04AA56; */
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

        .qr-code-container {
            text-align: center;
            margin: 30px 0;
        }

        .qr-code-container img {
            max-width: 200px;
            /* Adjust size as needed */
            height: auto;
            border: 1px solid #eee;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

            .qr-code-container img {
                max-width: 150px;
            }
        }
    </style>
</head>

<body style="background-color: #f0f4f8; padding: 8px;">
    <div class="email-container">
        <div class="email-header-banner">
            Permohonan Berjaya –
            <span style="text-transform: uppercase">{{ strtoupper($kursus->kur_nama ?? '') }}</span>
        </div>

        <div class="email-content">
            <p>YBhg. Datuk/ Dato’/ YBrs. Dr./Tuan/Puan,</p>

            <p>{{ strtoupper($pengguna->pen_ppnama ?? '[NAMA PEMOHON]') }},</p>

            <p>
                Dimaklumkan bahawa YBhg. Datuk/ Dato’/ YBrs. Dr./Tuan/Puan
                <strong>{{ strtoupper($pengguna->pen_nama ?? '[NAMA PEMOHON]') }}</strong> telah dipilih untuk mengikuti
                <strong>{{ strtoupper($kursus->kur_nama ?? '[NAMA KURSUS]') }}</strong> seperti butiran berikut :-
            </p>

            @php
                \Carbon\Carbon::setLocale('ms');

                $mula = isset($kursus->kur_tkhmula) && $kursus->kur_tkhmula
                    ? \Carbon\Carbon::parse($kursus->kur_tkhmula)
                    : null;

                $tamat = isset($kursus->kur_tkhtamat) && $kursus->kur_tkhtamat
                    ? \Carbon\Carbon::parse($kursus->kur_tkhtamat)
                    : null;

                if (!function_exists('formatMasa')) {
                    function formatMasa($time)
                    {
                        if (!$time)
                            return '';
                        [$hour, $minute] = explode(':', $time);
                        $hour = (int) $hour;
                        $minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                        $period = $hour < 12 ? 'pagi' : 'petang';
                        $displayHour = $hour % 12 === 0 ? 12 : $hour % 12;
                        return "{$displayHour}.{$minute} {$period}";
                    }
                }
            @endphp

            <div class="info-table-wrapper">
                <table class="info-table" cellpadding="4" cellspacing="0">
                    <tr>
                        <td><strong>Tarikh Kursus</strong></td>
                        <td>
                            : {{ $mula ? $mula->translatedFormat('d') : '[TARIKH MULA]' }} hingga
                            {{ $tamat ? $tamat->translatedFormat('d F Y') : '[TARIKH TAMAT]' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Masa</strong></td>
                        <td>
                            : {{ empty($kursus->kur_msamula) ? '[MASA MULA]' : formatMasa($kursus->kur_msamula) }} -
                            {{ empty($kursus->kur_msatamat) ? '[MASA TAMAT]' : formatMasa($kursus->kur_msatamat) }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tempat</strong></td>
                        <td>: {{ $kursus->eproTempat->tem_keterangan ?? '[TEMPAT KURSUS]' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Anjuran</strong></td>
                        <td>: {{ $kursus->etraPenganjur->pjr_keterangan ?? '[PENGANJUR KURSUS]' }}</td>
                    </tr>
                </table>
            </div>

            <p>
                Sila ambil maklum bahawa kehadiran ke kursus ini adalah <strong>diwajibkan</strong>.
                Sebarang perubahan atau pembatalan penyertaan hendaklah dimaklumkan kepada urus setia
                selewat-lewatnya <strong>14 hari sebelum</strong> tarikh kursus.
            </p>

            <div class="qr-code-container">
                <p>Sila imbas kod QR ini untuk kehadiran:</p>

                @if (!empty($qrCodeFilePath) && file_exists($qrCodeFilePath))
                    <img src="{{ $message->embed($qrCodeFilePath) }}" alt="Kod QR Kehadiran" class="qr-code-image">
                @else
                    <div style="background-color: black; width: 150px; height: 150px; margin: 30px auto;"></div>
                @endif
            </div>

            <p>Sekian, terima kasih.</p>

            <p style="margin: 0;"><strong>Urus Setia {{ config('app.name') }}</strong></p>
            <p style="margin-top: 0;">Kementerian Pelancongan, Seni dan Budaya</p>

            <hr style="width: 25%; border: none; border-top: 1px solid #eee; margin: 0 auto 20px auto;">

            <p style="font-size: 12px; color: #999; text-align: center; margin-top: 40px;">
                <em>Nota: E-mel ini dijana secara automatik. Tiada sebarang tindakan.</em>
            </p>
        </div>
    </div>
</body>

</html>