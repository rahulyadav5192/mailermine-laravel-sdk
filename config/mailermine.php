<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | MailerMine API Key
    |--------------------------------------------------------------------------
    |
    | Your MailerMine API key. Create one in the MailerMine dashboard.
    | Never commit this value — keep it in your environment file.
    |
    */

    'api_key' => env('MAILERMINE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | MailerMine Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of the MailerMine API, including the API version prefix.
    | Override this when pointing at a self-hosted or staging instance.
    |
    */

    'base_url' => env('MAILERMINE_BASE_URL', 'https://mailermine.com/api/v1'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum number of seconds to wait for an API response.
    |
    */

    'timeout' => (float) env('MAILERMINE_TIMEOUT', 30),

];
