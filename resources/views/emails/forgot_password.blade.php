<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body style="font-family: Arial, sans-serif">
    <h2>ULC Password Reset</h2>

    <p>Your password reset code is:</p>

    <h1 style="letter-spacing: 3px;">{{ $code }}</h1>

    <p>This code will expire in 10 minutes.</p>

    <a href="{{ $resetLink }}"
        style="
            display:inline-block;
            padding:12px 24px;
            background:#ff6b35;
            color:#ffffff;
            text-decoration:none;
            border-radius:6px;
            margin-top:20px;
            font-weight:bold;
       ">
        Reset Password
    </a>

    <p style="margin-top:20px;">
        If you did not request this, please ignore this email.
    </p>

    <br>
    <strong>Ultraritz Lending Corporation</strong>
</body>

</html>
