<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome New Team Member</title>
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
        <p>Dear {{$name}},</p>
    <p>
        We are excited to announce a new addition to our team! Please join us in welcoming {{$name}}, who has recently joined us as a Trainee.
    </p>
    <p>
        Your Email ID: <strong>{{$email}}</strong><br>
        Your Password: <strong>{{$password}}</strong>
    </p>
        </div>
        <div class="email-footer">
            <p>© {{ date('Y') }} ABSOL. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
