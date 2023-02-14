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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'keycrm'    => [
        'service_enabled'       => env('KEYCRM_ENABLED', false),
        'api_token'             => env('KEYCRM_API_TOKEN', ''),
        'url'                   => env('KEYCRM_URL', 'https://openapi.keycrm.app/v1/'),
        'action_lead'           => env('KEYCRM_ACTION_LEADS', 'leads'),
        'log'                   => env('KEYCRM_LOG_LEADS', false),
    ],

];
