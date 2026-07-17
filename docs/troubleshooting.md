# Troubleshooting

## Authentication failed (401)

- Confirm `MAILERMINE_API_KEY` is set and not empty.
- Confirm the key has not been revoked.
- Confirm you are not accidentally using a webhook signing secret as an API key.

## Feature or plan restricted (403)

A `PlanException` means the API key is valid but the action is not permitted —
usually because the feature is not on your plan, the account is restricted, or a
project-scoped key is being used across projects. The exception message includes
upgrade guidance, and `$e->getUpgradeUrl()` returns the billing URL. Include
`$e->getRequestId()` when contacting support.

## Connection / host errors

The default base URL is `https://mailermine.com/api/v1`. If you override
`MAILERMINE_BASE_URL`, include the `/api/v1` prefix:

```dotenv
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
```

## Validation failed (422)

Inspect field errors:

```php
use MailerMine\Exceptions\ValidationException;

try {
    $mm->emails()->send([...]);
} catch (ValidationException $e) {
    dump($e->getErrors());
}
```

Common causes: missing `from`/`to`/`subject`, unverified sending domain, or
invalid attachment encoding (content must be Base64).

## Resource not found (404)

Confirm you are using the correct ID field (`id` vs `uuid`) from the create
response. Campaigns typically expose `uuid`.

## Rate limited (429)

```php
use MailerMine\Exceptions\RateLimitException;

catch (RateLimitException $e) {
    $seconds = $e->getRetryAfter() ?? 60;
}
```

## Facade not found in Laravel

Run `composer dump-autoload` and clear config cache:

```bash
php artisan config:clear
php artisan package:discover
```

Confirm package discovery lists `MailerMine\Laravel\MailerMineServiceProvider`.

## Autocomplete missing for resources

Type-hint `MailerMine\Client` or use the `MailerMine` facade. Do not type-hint
generated OpenAPI classes.

## Webhook signature always invalid

- Use the **raw** request body, not a re-encoded JSON string.
- Use the webhook signing secret from create/rotate, not the API key.
- Accept either a raw hex digest or a `sha256=` prefixed value —
  `Webhooks::verify()` handles both.

## Still stuck?

- Search [GitHub Issues](https://github.com/rahulyadav5192/mailermine-laravel-sdk/issues)
- Open a [Discussion](https://github.com/rahulyadav5192/mailermine-laravel-sdk/discussions)
- Email support@mailermine.com
