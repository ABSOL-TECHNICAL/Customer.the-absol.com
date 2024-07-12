<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #141313;
            margin: 20px 0;
            text-align: center;
        }
        .email-footer {
            font-size: 12px;
            color: #777777;
            text-align: center;
            margin-top: 30px;
        }
        .email-footer .disclaimer {
            font-size: 10px;
            color: #999999;
            text-align: left;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            background-color: #FFA500;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('images/logo-transparent.png') }}" alt="Company Logo">
        </div>
        <div class="email-body">
            <p class="otp-code">Reset Your Password</p>
            <p>We received a request to reset your password. Click the button below to reset it.</p>
            <div class="btn-container">
                <a href="{{ $url }}" class="btn">Reset Password</a>
            </div>
            <p>This password reset link will expire in {{ $count }} minutes.</p>
            <p>If you did not request a password reset, please ignore this email.</p>
            <p>Best Regards,<br>Pwani</p>
            <div class="disclaimer">
                If you're having trouble clicking the "Reset Password" button, 
                copy and paste the URL below into your web browser:
                <a href="{{ $url }}">this link</a>.
            </div>
        </div>
        <div class="email-footer">
            <div>© {{ date('Y') }} ABSOL. All rights reserved.</div>
            
        </div>
    </div>
</body>
</html>
