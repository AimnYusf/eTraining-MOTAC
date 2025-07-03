<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body>
    <h2>Scan QR Code</h2>

    <div id="reader" style="width: 500px;"></div>
    <p>Result: <span id="result"></span></p>

    <script>
        const resultElement = document.getElementById('result');

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`QR Code detected: ${decodedText}`);
            resultElement.innerText = decodedText;

            // Optionally send to server via fetch/AJAX
            // fetch('/store-scan', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     },
            //     body: JSON.stringify({ qr_code: decodedText })
            // });
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        ).catch(err => {
            console.error("QR scanning error:", err);
        });
    </script>
</body>

</html>