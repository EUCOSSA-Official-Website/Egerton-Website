<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

    'pusher' => [
        'key' => "dc7341bc673250f3fc36",
        'secret' => "25f43953d99c2d5da7ed",
        'app_id' => "1939729",
        'cluster' => "mt1",
        'useTLS' => true,
    ],

    // BROADCAST_CONNECTION=pusher
    // PUSHER_APP_ID="1939729"
    // PUSHER_APP_KEY="dc7341bc673250f3fc36"
    // PUSHER_APP_SECRET="25f43953d99c2d5da7ed"
    // PUSHER_SCHEME="https"
    // PUSHER_PORT=443
    // PUSHER_HOST=
    // PUSHER_APP_CLUSTER="mt1"

];
