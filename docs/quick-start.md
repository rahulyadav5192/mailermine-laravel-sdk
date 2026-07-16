# Quick Start

Get from zero to a sent email in under five minutes.

## 1. Install

```bash
composer require mailermine/mailermine
```

## 2. Configure

**Laravel** — add to `.env`:

```dotenv
MAILERMINE_API_KEY=your-api-key
```

**Pure PHP:**

```php
$mm = new MailerMine\Client(getenv('MAILERMINE_API_KEY'));
```

## 3. Send an email

**Laravel facade:**

```php
use MailerMine\Facades\MailerMine;

$response = MailerMine::emails()->send([
    'from'    => 'MailerMine <hello@mailermine.com>',
    'to'      => 'john@example.com',
    'subject' => 'Hello from MailerMine',
    'html'    => '<h1>It works!</h1>',
]);

echo $response->data()['uuid'];
```

**Dependency injection:**

```php
use MailerMine\Client;

class WelcomeMailer
{
    public function __construct(private readonly Client $mailermine) {}

    public function send(string $email): void
    {
        $this->mailermine->emails()->send([
            'from'    => 'hello@mailermine.com',
            'to'      => $email,
            'subject' => 'Welcome',
            'html'    => '<p>Welcome aboard!</p>',
        ]);
    }
}
```

## 4. What to build next

| Goal | Guide |
| ---- | ----- |
| Verify a sending domain | [Domains](domains.md) |
| Reuse HTML with templates | [Templates](templates.md) |
| Manage subscribers | [Contacts](contacts.md) |
| Send a marketing campaign | [Campaigns](campaigns.md) |
| Read engagement metrics | [Analytics](analytics.md) |
| Receive delivery events | [Webhooks](webhooks.md) |

## Tip

Every resource returns either a `Response` (single object) or a `Collection`
(list with optional pagination). You never need to look at generated OpenAPI
classes.
