<!DOCTYPE html>
<html>
<head>
    <title>Your OTP Code</title>
</head>
<body>
    <p>Hi,</p>

    <p>Your One Time Password (OTP) is:</p>

    <h2>{{ $otp }}</h2>

    <p>This OTP is valid for 10 minutes. Please do not share it with anyone.</p>

    <p>Thank you,<br>
    {{ config('app.name') }}</p>
</body>
</html>
