<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Permohonan Akaun E-mel dan ID Pengguna</title>
</head>

<body>

    <p>Assalamualaikum dan Salam Sejahtera,</p>
    <br>
    <p>Tuan/Puan,</p>
    <br>
    <p>Perkara di atas adalah dirujuk.</p>

    <p>
        Adalah dimaklumkan terdapat transaksi Permohonan Akaun E-mel Individu dan ID Pengguna untuk tindakan sokongan
        tuan/puan.
    </p>
    <br>
    <p><strong><u>Maklumat Permohonan</u></strong></p>
    <table cellpadding="4" cellspacing="0">
        <tr>
            <td>Tindakan</td>
            <td>: (<a href="http://127.0.0.1:8000/pengesahan/{{ $mailData['encrypted_id'] }}">Sila klik di
                    sini</a>)</td>
        </tr>
        <tr>
            <td>Nama Kursus</td>
            <td>: {{ $mailData['nama_kursus'] }}</td>
        </tr>
        <tr>
            <td>Tarikh Kursus</td>
            <td>: {{ $mailData['tarikh_mula'] }} hingga {{ $mailData['tarikh_tamat'] }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $mailData['nama'] }}</td>
        </tr>
        <tr>
            <td>Jawatan</td>
            <td>: {{ $mailData['jawatan'] }} {{ $mailData['gred'] }}</td>
        </tr>
    </table>
    <br>

    <p>Sekian, terima kasih.</p>

    <p>Pentadbir Perkhidmatan E-mel dan ID Pengguna</p>

    <p><em>Nota : E-mel ini dijana secara automatik, sila jangan balas e-mel ini.</em></p>

    <hr>

    <p><strong>"MALAYSIA MADANI"</strong></p>
    <p><strong>"BERKHIDMAT UNTUK NEGARA"</strong></p>
    <p>Saya yang menjalankan amanah,</p>

</body>

</html>