<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registration OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            background-color: #ffffff;
            padding: 30px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            color: #333333;
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header img {
            max-width: 150px;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.8;
            color: #555555;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin: 20px 0;
            text-align: center;
        }

        .email-footer {
            font-size: 12px;
            color: #999999;
            text-align: center;
            margin-top: 40px;
        }

        .disclaimer {
            font-size: 10px;
            color: #cccccc;
            text-align: left;
            margin-top: 20px;
        }

        .whatsapp img {
            max-width: 100%;
            height: auto;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            color: #ffffff;
            background-color: #28a745;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('images/logo-transparent.png') }}" alt="Company Logo">
        </div>
        <div class="email-body">



            <p class="otp-code">Hi User <br> Your Registration OTP is: {{ $code }}</p>

            <p>This code will be valid for 120 seconds.</p>
            <p>If you did not request a code, please ignore this email.</p>
            <p>Best Regards,<br>Pwani</p>
            <p style="text-align: center;">© {{ date('Y') }} ABSOL. All rights reserved.</p>

            <div class="whatsapp">
                <a href="https://api.whatsapp.com/send/?phone=254743123456&text&type=phone_number&app_absent=0">
                    <img src="{{ asset('images/Email-Footer.jpg') }}" alt="Footer Image">
                </a>
            </div>
        </div>
        <div class="email-footer">
            <div class="disclaimer">
                <p>Disclaimer: The contents of this electronic mail message and any attachments are confidential and may be legally privileged and protected from discovery or disclosure. This message is intended only for the personal and confidential use of the intended addressee(s). If you have received this message in error, you are not authorized to view, disseminate, distribute, or copy this message or any part of it without our consent, and you are requested to return it to the sender immediately and delete all copies from your system. Your Company cannot guarantee that this message or any attachment is virus-free, does not contain malicious code, or is incomplete.</p>
            </div>
        </div>
    </div>
</body>

</html>