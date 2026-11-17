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

    /*
    |--------------------------------------------------------------------------
    | Retries
    |--------------------------------------------------------------------------
    |
    | Rate-limited (429) and temporarily unavailable (502/503/504) responses
    | and connection failures are retried with backoff, honouring the API's
    | Retry-After header. Email sends carry an Idempotency-Key, so a retry is
    | never delivered twice. Set max_retries to 0 to disable.
    |
    */

    'max_retries' => (int) env('MAILERMINE_MAX_RETRIES', 2),

    'max_retry_delay' => (float) env('MAILERMINE_MAX_RETRY_DELAY', 30),

];
