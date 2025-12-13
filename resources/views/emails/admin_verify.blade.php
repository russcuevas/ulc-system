<!DOCTYPE html>
<html>

<head>
    <title>Account Verification</title>
</head>

<body>
    <p>Hello {{ $fullname }},</p>
    <p>Please click the link below to verify your admin account:</p>
    <p><a href="{{ $url }}">Verify Account</a></p>
    <p>If you did not request this, ignore this email.</p>
</body>

</html>
