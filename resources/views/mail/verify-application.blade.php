<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Sahkan Permohonan Kursus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            padding: 20px;
            color: #333;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>eProgram</h2>
        <p>Assalamualaikum dan salam sejahtera,</p>

        <p>Tuan/Puan,</p>

        <p>Perkara di atas adalah dirujuk. <br>
            Permohonan kursus bagi pemohon berikut telah direkodkan dan memerlukan tindakan sokongan Tuan/Puan.</p>

        <p><strong><u>Maklumat Pemohon</u></strong></p>
        <ul>
            <li><strong>Nama Kursus:</strong>{{ $mailData['nama_kursus'] }}</li>
            <li><strong>Tarikh Kursus:</strong>{{ $mailData['tarikh_mula'] }} hingga {{ $mailData['tarikh_tamat'] }}
            </li>
            <li><strong>Nama Pemohon:</strong>{{ $mailData['nama'] }}</li>
            <li><strong>Jawatan / Gred:</strong>{{ $mailData['jawatan'] }} {{ $mailData['gred'] }}</li>
        </ul>

        <p>Sila klik butang di bawah untuk mengesahkan permohonan ini:</p>

        <a href="http://127.0.0.1:8000/pegawai-penyokong/{{ $mailData['encrypted_id'] }}" class="button">Sahkan
            Permohonan</a>

        <p class="footer">
            Nota : E-mel ini dijana secara automatik, sila jangan balas e-mel ini.
        </p>
    </div>
</body>

</html>