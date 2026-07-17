# Authentication

MailerMine authenticates every request with a Bearer API key.

## Create an API key

1. Sign in to the [MailerMine dashboard](https://mailermine.com).
2. Open **Settings → API Keys**.
3. Create a key with the scopes your application needs.
4. Copy the key immediately — it is shown only once.

## Configure the SDK

### Laravel

```dotenv
MAILERMINE_API_KEY=mm_live_...
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
```

The service provider reads these values into `config/mailermine.php`.

### Pure PHP

```php
use MailerMine\Client;
use MailerMine\Config\Configuration;

// Simplest
$mm = new Client(getenv('MAILERMINE_API_KEY'));

// Explicit configuration
$mm = new Client(new Configuration(
    apiKey: getenv('MAILERMINE_API_KEY'),
    baseUrl: 'https://mailermine.com/api/v1',
    timeout: 30.0,
));
```

## Security best practices

- Store keys in environment variables — never commit them.
- Use separate keys for local, staging, and production.
- Rotate keys if they are exposed; revoke old keys in the dashboard.
- Prefer the least privilege when creating keys.

## Authentication errors

Invalid or missing keys raise `MailerMine\Exceptions\AuthenticationException`
(HTTP 401):

```php
use MailerMine\Exceptions\AuthenticationException;

try {
    $mm->emails()->send([...]);
} catch (AuthenticationException $e) {
    // Check MAILERMINE_API_KEY
}
```

A valid key that lacks access to a feature — because the plan does not include
it, the account is restricted, or the key is used across projects — raises
`MailerMine\Exceptions\PlanException` (HTTP 403) instead. Its message includes
upgrade guidance, and `getUpgradeUrl()` returns the billing URL:

```php
use MailerMine\Exceptions\PlanException;

try {
    $mm->emails()->send([...]);
} catch (PlanException $e) {
    return redirect()->away($e->getUpgradeUrl());
}
```

## Webhook signing secrets

Webhook endpoints have a separate signing secret used for HMAC verification.
See [Webhooks](webhooks.md). That secret is not your API key.
