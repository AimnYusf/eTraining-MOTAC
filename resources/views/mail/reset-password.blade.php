<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tetapan Semula Kata Laluan</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px;">
        <h2>Hai, {{ $name }}</h2>
        <p>Anda telah meminta tetapan semula kata laluan. Klik butang di bawah untuk menetapkan semula:</p>
        <p style="text-align: center;">
            <a href="{{ $url }}"
                style="display:inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Tetapkan
                Semula Kata Laluan</a>
        </p>
        <p>Jika anda tidak membuat permintaan ini, abaikan emel ini.</p>
        <p>Terima kasih.</p>
    </div>
</body>

</html>