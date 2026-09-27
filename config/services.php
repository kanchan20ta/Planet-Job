<?php

return [
'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI=https://www.planetjob.com.np'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'postmark' => ['token' => env('POSTMARK_TOKEN')],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Nepal-market + international payment gateways for the Employer
    // Subscription flow — wire real credentials in .env when integrating.
    'esewa' => [
        'merchant_code' => env('ESEWA_MERCHANT_CODE'),
        'url' => env('ESEWA_URL', 'https://rc-epay.esewa.com.np'),
    ],
    'khalti' => [
        'secret_key' => env('KHALTI_SECRET_KEY'),
        'url' => env('KHALTI_URL', 'https://a.khalti.com'),
    ],
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
];
