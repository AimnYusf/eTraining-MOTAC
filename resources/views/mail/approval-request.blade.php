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

        .btn-action {
            display: inline-block;
            background-color: #2F8AD0;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            width: 50%;
            margin-top: 25px;
            border-radius: 5px;
            /* Added border-radius back for the button */
            font-weight: 600;
            /* Adjusted font-weight for button */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Added transition for hover effect */
        }

        .btn-action:hover {
            background-color: #2671b3;
            transform: translateY(-1px);
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
            width: 35%;
            /* Adjusted width for labels */
            font-weight: 600;
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

            .info-table-wrapper {
                padding: 15px;
                margin: 15px auto;
            }

            .btn-action {
                padding: 10px 20px;
                font-size: 15px;
                width: 70%;
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
    <div class="container">
        <div class="container-header">
        </div>
        <div class="content">
            <div class="header">
                Tindakan: Permohonan Kursus
                <span style="text-transform: uppercase;">
                    {{ $mailData['nama'] ?? '' }}
                </span> Untuk Sokongan
            </div>

            <hr style="margin-top: 20px; margin-bottom: 20px; border: none; border-top: 1px solid #eee;">

            <p>Assalamualaikum dan Salam Sejahtera,</p>
            <p>Tuan/Puan,</p>
            <p>Perkara di atas adalah dirujuk.</p>

            <p>
                Adalah dimaklumkan terdapat transaksi Permohonan
                <span style="text-transform: uppercase;">
                    <strong>{{ $mailData['nama_kursus'] ?? '' }}</strong>
                </span>
                untuk <strong>tindakan sokongan tuan/puan.</strong>
            </p>

            <p><strong><u>Maklumat Permohonan</u></strong></p>
            <div class="info-table-wrapper">
                <table class="info-table" cellpadding="4" cellspacing="0">
                    <tr>
                        <td>Nama Pemohon</td>
                        <td>: <strong>{{ $mailData['nama'] ?? '' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Jawatan Pemohon</td>
                        <td>: <strong>{{ $mailData['jawatan'] ?? '' }} {{ $mailData['gred'] ?? '' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Nama Kursus</td>
                        <td>: <strong>{{ $mailData['nama_kursus'] ?? '' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Tarikh Kursus</td>
                        @php
                            \Carbon\Carbon::setLocale('ms');
                            $mula = !empty($mailData['tarikh_mula']) ? \Carbon\Carbon::parse($mailData['tarikh_mula']) : null;
                            $tamat = !empty($mailData['tarikh_tamat']) ? \Carbon\Carbon::parse($mailData['tarikh_tamat']) : null;
                        @endphp
                        <td>:
                            <strong>
                                {{ $mula ? $mula->translatedFormat('d') : '' }} hingga
                                {{ $tamat ? $tamat->translatedFormat('d F Y') : '' }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Lokasi Kursus</td>
                        <td>: <strong>{{ $mailData['tempat'] ?? '' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <strong style="text-transform: uppercase;">{{ $mailData['status'] ?? '' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Tarikh Permohonan</td>
                        <td>:
                            @php
                                $tarikhMohon = !empty($mailData['tarikh_mohon']) ? \Carbon\Carbon::parse($mailData['tarikh_mohon']) : null;
                            @endphp
                            <strong>{{ $tarikhMohon ? $tarikhMohon->translatedFormat('d F Y') : '' }}</strong>
                        </td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
                @if (!empty($mailData['url']))
                    <a href="{{ $mailData['url'] }}" target="_blank"
                        style="display: inline-block; background-color: #2F8AD0; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-weight: 600; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                        class="btn-action">Klik Untuk Kelulusan</a>
                @endif
            </p>

            <p>Sekian, terima kasih.</p>
            <p><strong>Pentadbir Sistem [Nama Sistem]</strong></p>
            <hr style="width: 25%; border: none; border-top: 1px solid #eee; margin: 0 auto 20px auto;">

            <p style="text-align: center; font-size: 14px; color: #777;">
                <em>Jika anda tidak mendaftar akaun ini, sila abaikan emel ini.</em>
            </p>
        </div>
    </div>
</body>

</html>