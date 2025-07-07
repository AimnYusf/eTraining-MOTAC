<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sahkan Emel Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease-in-out;
        }

        .header {
            text-align: center;
            padding-bottom: 0px;
        }

        .header h1 {
            color: #2c3e50;
        }

        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .logo-motac {
            width: 30%;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .email-heading {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            color: #3d4852;
            font-size: 18px;
            font-weight: bold;
            margin-top: 18px;
            text-align: left;
        }

        .btn-verify {
            display: inline-block;
            background-color: #2d3748;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 28px;
            margin-top: 25px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-motac.png') }}" alt="Logo MOTAC" class="logo-motac" />
        </div>
        <div class="content">
            <h1 class="email-heading">Hai, Muhammad Aiman Yusuf!</h1>
            <p>Terima kasih kerana mendaftar! Sebelum anda mula, sila sahkan alamat emel anda dengan menekan butang di
                bawah:</p>
            <p style="text-align: center;">
                <a href="" class="btn-verify">Sahkan Sekarang</a>
            </p>
            <p>Jika anda tidak mendaftar akaun ini, sila abaikan emel ini.</p>
        </div>
        <div class="footer">
            &copy; 2025 Kementerian Pelancongan, Seni dan Budaya
        </div>
    </div>
</body>

</html>