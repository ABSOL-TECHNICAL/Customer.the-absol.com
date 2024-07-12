<?php

return [
    'table_name' => 'otp_codes',

    'user_model' => env('OTP_LOGIN_USER_MODEL', 'App\\Models\\Customer'),

    'otp_code' => [
        'length' => env('OTP_LOGIN_CODE_LENGTH', 4),
        'expires' => env('OTP_LOGIN_CODE_EXPIRES_SECONDS', 120),
    ],
];
