<!-- resources/views/emails/registration-otp.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration OTP</title>
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
    
        .email-footer {
            font-size: 12px;
            color: #777777;
            text-align: center;
            margin-top: 30px;
        }

    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
        <img src="{{ asset('images/logo-transparent.png') }}" alt="Company Logo">
        </div>
        <div class="email-body">
        Dear Sir/Madam,

        We are pleased to inform you that your application has been Approved.
         We appreciate the time and effort you took to submit your application, and we are excited to move forward with the next steps.
        </div>
        <div class="email-footer">
            <div>© {{ date('Y') }} ABSOL. All rights reserved.</div>
        </div>
    </div>
</body>
</html>
