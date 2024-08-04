<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code Generator</title>
</head>
<body>

    {!! QrCode::size(300)->generate($qrData) !!}


</body>
</html>
