<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Pengesahan Kehadiran Kursus - MOTAC Training & Management System</title>
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
            max-width: 600px;
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

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px 0;
            vertical-align: top;
            font-size: 15px;
            color: #555;
        }

        .info-table td:first-child {
            width: 35%;
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

            .qr-code-container img {
                max-width: 150px;
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

<body>
    <div class="container">
        <div class="container-header">
            <!-- This header can be used for a logo or a small title if needed, currently empty -->
        </div>
        <div class="content">
            <div class="header">Pengesahan Kehadiran Kursus</div>
            <hr style="margin-top: 20px; margin-bottom: 20px; border: none; border-top: 1px solid #eee;">

            <p>Terima kasih kerana mendaftar untuk <strong>Kursus Bina Insan : High Performance & Values Internalization</strong>.</p>

            <div class="qr-code-container">
                <p>Sila imbas kod QR ini untuk kehadiran:</p>
                <img src="[QR_CODE_IMAGE_URL_HERE]" alt="QR Code Kehadiran" onerror="this.onerror=null;this.src='https://placehold.co/200x200/cccccc/ffffff?text=QR+Code+Not+Found';">
            </div>

            <p style="font-size: 12px; color: #999; text-align: center; margin-top: 40px;">
                <em>Nota : Emel ini dijana secara automatik, sila jangan balas e-mel ini.</em>
            </p>
        </div>
    </div>
</body>

</html>