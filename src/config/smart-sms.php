<?php
return [
    'line_number' => env('SMS_LINE_NUMBER'),
    'user_id' => env('SMS_USER_ID'),
    'password' => env('SMS_PASSWORD'),
    'default_sms_rcpt' => env('SMS_DEFAULT_SMS_RCPT'),
    'mobile_field_name' => env('SMS_MOBILE_FIELD_NAME', 'mobile')
];