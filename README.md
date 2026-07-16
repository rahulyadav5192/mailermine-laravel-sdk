<h1 align="center">MailerMine PHP & Laravel SDK</h1>

<p align="center">
  The official PHP & Laravel SDK for <a href="https://mailermine.com">MailerMine</a> —
  send transactional email, run campaigns, manage contacts, and read analytics with a clean, typed, Laravel-native API.
</p>

<p align="center">
  <a href="https://packagist.org/packages/mailermine/mailermine"><img src="https://img.shields.io/packagist/v/mailermine/mailermine.svg?style=flat-square" alt="Latest Version on Packagist"></a>
  <a href="https://packagist.org/packages/mailermine/mailermine"><img src="https://img.shields.io/packagist/dt/mailermine/mailermine.svg?style=flat-square" alt="Total Downloads"></a>
  <a href="https://github.com/rahulyadav5192/mailermine-laravel-sdk/actions/workflows/ci.yml"><img src="https://img.shields.io/github/actions/workflow/status/rahulyadav5192/mailermine-laravel-sdk/ci.yml?branch=main&style=flat-square&label=tests" alt="Tests"></a>
  <img src="https://img.shields.io/badge/php-%5E8.3-777BB4?style=flat-square" alt="PHP Version">
  <a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square" alt="License"></a>
</p>

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
  - [Laravel](#laravel)
  - [Pure PHP](#pure-php)
- [Configuration](#configuration)
- [Authentication](#authentication)
- [Quick Start](#quick-start)
- [Documentation](#documentation)
- [Usage](#usage)
  - [Transactional Emails](#transactional-emails)
  - [Domains](#domains)
  - [Templates](#templates)
  - [Campaigns](#campaigns)
  - [Contacts, Lists, Segments & Tags](#contacts-lists-segments--tags)
  - [Analytics](#analytics)
  - [Message Events & Delivery Logs](#message-events--delivery-logs)
  - [Webhooks](#webhooks)
  - [Suppressions](#suppressions)
- [Working with Responses](#working-with-responses)
- [Collections & Pagination](#collections--pagination)
- [Error Handling](#error-handling)
- [Testing](#testing)
- [Available Resources](#available-resources)
- [Contributing](#contributing)
- [Security](#security)
- [Support](#support)
- [License](#license)

## Features

- **Transactional email** with attachments, CC/BCC, templates, tags, and metadata.
- **Campaigns** — create, schedule, send, pause/resume, and read analytics & events.
- **Audience management** — contacts, lists, audiences, segments, tags, imports, and exports.
- **Deliverability** — domains, DNS records, suppressions, message events, and delivery logs.
- **Webhooks** — full CRUD, secret rotation, delivery inspection, event replay, and local HMAC signature verification.
- **First-class Laravel integration** — auto-discovered service provider, `MailerMine` facade, and publishable config.
- **Framework-agnostic** — works in any PHP 8.3+ project, with or without Laravel.
- **Typed & discoverable** — full IDE autocomplete, typed exceptions, and clean `Response`/`Collection` value objects.
- **Battle-tested** — PHPStan level 8, Laravel Pint, and a comprehensive test suite in CI.

## Requirements

| Requirement | Version              |
| ----------- | -------------------- |
| PHP         | 8.3 or 8.4           |
| Laravel     | 12.x or 13.x (optional) |
| Extensions  | `curl`, `json`, `mbstring` |

## Installation

Install the package via Composer:

```bash
composer require mailermine/mailermine
```

### Laravel

The service provider and `MailerMine` facade are registered automatically through
Laravel package discovery — no manual setup required.

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=mailermine-config
```

Add your credentials to `.env`:

```dotenv
MAILERMINE_API_KEY=your-api-key
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
MAILERMINE_TIMEOUT=30
```

### Pure PHP

No framework required — instantiate the client directly:

```php
require __DIR__.'/vendor/autoload.php';

use MailerMine\Client;

$mm = new Client('your-api-key');

// Or with a custom base URL (e.g. self-hosted or staging):
$mm = new Client('your-api-key', 'https://mailermine.com/api/v1');
```

## Configuration

When using Laravel, all configuration lives in `config/mailermine.php`:

```php
return [
    'api_key'  => env('MAILERMINE_API_KEY'),
    'base_url' => env('MAILERMINE_BASE_URL', 'https://mailermine.com/api/v1'),
    'timeout'  => (float) env('MAILERMINE_TIMEOUT', 30),
];
```

For advanced configuration in any environment, build a `Configuration` object:

```php
use MailerMine\Client;
use MailerMine\Config\Configuration;

$config = new Configuration(
    apiKey: 'your-api-key',
    baseUrl: 'https://mailermine.com/api/v1',
    timeout: 30.0,
    userAgent: 'my-app/1.0',
    debug: false,
);

$mm = new Client($config);
```

## Authentication

MailerMine authenticates with a Bearer API key. Create one in your
[MailerMine dashboard](https://mailermine.com) and store it in an environment
variable — **never commit API keys to source control**.

## Quick Start

Resolve the client and send your first email.

**Laravel (facade):**

```php
use MailerMine\Facades\MailerMine;

$email = MailerMine::emails()->send([
    'from'    => 'MailerMine <hello@mailermine.com>',
    'to'      => 'john@example.com',
    'subject' => 'Hello from MailerMine',
    'html'    => '<h1>It works!</h1>',
]);

echo $email->data()['uuid'];
```

**Laravel (dependency injection):**

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

**Pure PHP:**

```php
$mm = new MailerMine\Client('your-api-key');

$mm->emails()->send([
    'from'    => 'hello@mailermine.com',
    'to'      => 'john@example.com',
    'subject' => 'Hello',
    'html'    => '<p>Hi there</p>',
]);
```

> The rest of this guide uses a `$mm` client instance. In Laravel you can swap
> `$mm->` for the `MailerMine::` facade anywhere.

## Documentation

Step-by-step guides live in the [`docs/`](docs) directory:

| Guide | Description |
| ----- | ----------- |
| [Installation](docs/installation.md) | Composer install for Laravel and pure PHP |
| [Quick start](docs/quick-start.md) | First email in minutes |
| [Authentication](docs/authentication.md) | API keys |
| [Transactional email](docs/transactional.md) | Send, attachments, templates |
| [Domains](docs/domains.md) | DNS verification |
| [Templates](docs/templates.md) | Reusable templates |
| [Contacts](docs/contacts.md) | Audience management |
| [Campaigns](docs/campaigns.md) | Create, schedule, send |
| [Analytics](docs/analytics.md) | Engagement metrics |
| [Webhooks](docs/webhooks.md) | Endpoints and signature verification |
| [FAQ](docs/faq.md) | Common questions |
| [Troubleshooting](docs/troubleshooting.md) | Debugging |
| [Migration](docs/migration.md) | Version upgrades |

## Usage

### Transactional Emails

```php
// Simple send
$mm->emails()->send([
    'from'     => 'hello@mailermine.com',
    'to'       => 'john@example.com',
    'subject'  => 'Your receipt',
    'html'     => '<p>Thanks for your purchase.</p>',
    'text'     => 'Thanks for your purchase.',
    'reply_to' => 'support@mailermine.com',
    'tags'     => ['receipt'],
    'metadata' => ['order_id' => 1234],
]);

// Multiple recipients + CC/BCC (string or array accepted)
$mm->emails()->send([
    'from'    => 'sales@mailermine.com',
    'to'      => ['a@example.com', 'b@example.com'],
    'cc'      => 'manager@example.com',
    'bcc'     => ['archive@example.com'],
    'subject' => 'Quote',
    'html'    => '<p>See attached.</p>',
]);

// Attachments (Base64 encoded content)
$mm->emails()->send([
    'from'        => 'billing@mailermine.com',
    'to'          => 'john@example.com',
    'subject'     => 'Invoice',
    'html'        => '<p>Invoice attached.</p>',
    'attachments' => [[
        'filename'     => 'invoice.pdf',
        'content'      => base64_encode(file_get_contents('invoice.pdf')),
        'content_type' => 'application/pdf',
    ]],
]);

// Send with a template
$mm->emails()->send([
    'from'        => 'hello@mailermine.com',
    'to'          => 'john@example.com',
    'template_id' => $templateId,
    'variables'   => ['first_name' => 'John'],
]);

// Inspect sent messages
$email  = $mm->emails()->get($messageId);
$events = $mm->emails()->events($messageId);
$recent = $mm->emails()->list(['status' => 'sent', 'page' => 1]);
```

### Domains

```php
$domain = $mm->domains()->create(['domain' => 'mail.example.com']);
$id     = $domain->data()['id'];

// DNS records you need to add
foreach ($mm->domains()->dnsRecords($id) as $record) {
    echo "{$record['type']} {$record['name']} {$record['value']}\n";
}

$mm->domains()->verify($id);
$mm->domains()->status($id);
$mm->domains()->list(['status' => 'verified']);
$mm->domains()->delete($id);
```

### Templates

```php
$template = $mm->templates()->create([
    'name'    => 'Welcome Email',
    'subject' => 'Welcome {{first_name}}',
    'html'    => '<h1>Welcome {{first_name}}!</h1>',
    'text'    => 'Welcome {{first_name}}!',
]);

$id = $template->data()['id'];

$mm->templates()->preview($id, ['first_name' => 'John']);
$mm->templates()->update($id, ['subject' => 'Hey {{first_name}}']);
$mm->templates()->duplicate($id, ['name' => 'Welcome (copy)']);
$mm->templates()->list(['search' => 'welcome']);
$mm->templates()->delete($id);
```

### Campaigns

```php
// Create a fully configured draft in one call
$campaign = $mm->campaigns()->create([
    'name'        => 'March Newsletter',
    'subject'     => "What's new this month",
    'from_name'   => 'MailerMine',
    'from_email'  => 'news@mailermine.com',
    'template_id' => $templateId,
]);

$id = $campaign->data()['uuid'];

// Recipients
$mm->campaigns()->addAudience($id, $audienceId);
$mm->campaigns()->addSegment($id, $segmentId);
$count = $mm->campaigns()->recipientCount($id);

// Content helpers
$mm->campaigns()->setTemplate($id, $templateId);
$mm->campaigns()->setSubject($id, 'A better subject');
$mm->campaigns()->setSender($id, 'news@mailermine.com', 'MailerMine');

// Schedule for later…
$mm->campaigns()->schedule($id, [
    'scheduled_at' => '2026-08-01T09:00:00+00:00',
    'timezone'     => 'UTC',
]);

// …or send right now
$mm->campaigns()->sendNow($id);

// Lifecycle
$mm->campaigns()->pause($id);
$mm->campaigns()->resume($id);
$mm->campaigns()->cancel($id);
$mm->campaigns()->archive($id);

// Analytics & events
$analytics = $mm->campaigns()->analytics($id);
$opens     = $mm->campaigns()->opens($id);
$clicks    = $mm->campaigns()->clicks($id);
$events    = $mm->campaigns()->events($id);
```

### Contacts, Lists, Segments & Tags

```php
// Contacts
$contact = $mm->contacts()->upsert([
    'email'      => 'john@example.com',
    'first_name' => 'John',
    'subscribed' => true,
]);

$id = $contact->data()['id'];

$mm->contacts()->update($id, ['last_name' => 'Doe']);
$mm->contacts()->subscribe($id);
$mm->contacts()->unsubscribe($id);
$mm->contacts()->list(['subscribed' => true, 'page' => 1]);
$mm->contacts()->search('john');

// Lists
$list = $mm->lists()->create(['name' => 'Newsletter']);
$mm->lists()->addContact($list->data()['id'], $id);

// Segments (dynamic)
$segment = $mm->segments()->create([
    'name'  => 'Active subscribers',
    'rules' => [
        'logic' => 'and',
        'rules' => [
            ['field' => 'subscribed', 'operator' => 'equals', 'value' => true],
        ],
    ],
]);
$mm->segments()->preview($segment->data()['id']);

// Tags
$tag = $mm->tags()->create(['name' => 'vip']);
$mm->tags()->assign([
    'contact_ids' => [$id],
    'tag_ids'     => [$tag->data()['id']],
]);

// Imports & exports
$import = $mm->imports()->create(['file' => '/path/to/contacts.csv']);
$mm->imports()->status($import->data()['id']);

$export = $mm->exports()->create(['status' => 'active', 'subscribed' => true]);
$csv    = $mm->exports()->download($export->data()['id']);
```

### Analytics

```php
$range = ['from' => '2026-01-01', 'to' => '2026-01-31'];

$overview = $mm->analytics()->overview($range);

$mm->analytics()->deliveries($range);
$mm->analytics()->opens($range);
$mm->analytics()->clicks($range);
$mm->analytics()->bounces($range);
$mm->analytics()->complaints($range);
$mm->analytics()->unsubscribes($range);
$mm->analytics()->usage($range);
$mm->analytics()->activity($range);

// Filter by project, domain, or campaign
$mm->analytics()->opens(['from' => '2026-01-01', 'campaign_id' => $campaignId]);
```

Dates accept ISO-8601 strings or `DateTimeInterface` instances.

### Message Events & Delivery Logs

```php
// Platform-wide event stream
$mm->events()->list(['type' => 'email.opened', 'from' => '2026-01-01']);
$mm->events()->get($eventId);

// A single message's timeline
$mm->events()->timeline($messageId);
$mm->events()->history($messageId);

// Delivery logs
$mm->messages()->list(['status' => 'delivered']);
$mm->messages()->search('john@example.com');
$mm->messages()->filter(['status' => 'bounced', 'from' => '2026-01-01']);
```

### Webhooks

```php
$webhook = $mm->webhooks()->create([
    'name'              => 'Production events',
    'url'               => 'https://example.com/webhooks/mailermine',
    'subscribed_events' => ['email.delivered', 'email.opened', 'email.bounced'],
]);

// The signing secret is only returned on create/rotate — store it now.
$secret = $webhook->data()['secret'];

$mm->webhooks()->list();
$mm->webhooks()->update($id, ['is_active' => false]);
$mm->webhooks()->rotateSecret($id);
$mm->webhooks()->test($id);

// Inspect deliveries and replay failures
$mm->webhooks()->deliveries($id);
$mm->webhooks()->failures($id);
$mm->webhooks()->replay($id);
$mm->webhooks()->retry($deliveryId);
```

**Verifying incoming webhooks** — MailerMine signs each payload with
HMAC-SHA256. Always verify before trusting a request:

```php
use MailerMine\Resources\Webhooks;

$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_MAILERMINE_SIGNATURE'] ?? '';

if (! Webhooks::verify($payload, $signature, $secret)) {
    http_response_code(401);
    exit;
}

$event = json_decode($payload, true);
```

In Laravel:

```php
use Illuminate\Http\Request;
use MailerMine\Resources\Webhooks;

public function handle(Request $request)
{
    $valid = Webhooks::verify(
        $request->getContent(),
        $request->header('X-MailerMine-Signature', ''),
        config('services.mailermine.webhook_secret'),
    );

    abort_unless($valid, 401);

    // Handle $request->json()->all()
}
```

### Suppressions

```php
$check = $mm->suppressions()->check('john@example.com');

if (! ($check->data()['suppressed'] ?? false)) {
    $mm->suppressions()->add([
        'email'  => 'john@example.com',
        'reason' => 'manual',
    ]);
}

$mm->suppressions()->list(['reason' => 'bounce']);
$mm->suppressions()->remove($suppressionId);
```

## Working with Responses

Every single-resource call returns an immutable `Response` object. It hides the
generated model details while giving you convenient access to the payload:

```php
$response = $mm->emails()->send([...]);

$response->data();      // The primary payload (the `data` key when present)
$response->message();   // API message string, or null
$response->success();   // bool|null
$response->toArray();   // Full payload as an array
$response['uuid'];      // ArrayAccess to the payload
json_encode($response); // JsonSerializable
```

## Collections & Pagination

List calls return an immutable, iterable `Collection`:

```php
$contacts = $mm->contacts()->list(['page' => 1, 'per_page' => 25]);

count($contacts);          // number of items on the page
$contacts->isEmpty();
$contacts->first();
$contacts->all();          // list<array>

foreach ($contacts as $contact) {
    echo $contact['email'];
}

if ($page = $contacts->pagination()) {
    $page->currentPage;    // int
    $page->perPage;        // int
    $page->total;          // int
    $page->lastPage;       // int
    $page->hasMorePages(); // bool
}
```

Paginate through every page:

```php
$page = 1;

do {
    $contacts = $mm->contacts()->list(['page' => $page, 'per_page' => 100]);

    foreach ($contacts as $contact) {
        // process $contact
    }

    $meta = $contacts->pagination();
    $page++;
} while ($meta && $meta->hasMorePages());
```

## Error Handling

The SDK maps API failures to typed exceptions, all extending `ApiException`:

| Exception                 | HTTP status | When                              |
| ------------------------- | ----------- | --------------------------------- |
| `AuthenticationException` | 401 / 403   | Missing or invalid API key        |
| `NotFoundException`       | 404         | Resource does not exist           |
| `ValidationException`     | 422         | Invalid request data              |
| `RateLimitException`      | 429         | Rate limit exceeded               |
| `ApiException`            | other       | Any other API/transport error     |

```php
use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\AuthenticationException;
use MailerMine\Exceptions\RateLimitException;
use MailerMine\Exceptions\ValidationException;

try {
    $mm->emails()->send([...]);
} catch (ValidationException $e) {
    // Field-level validation errors
    foreach ($e->getErrors() as $field => $messages) {
        // ...
    }
} catch (RateLimitException $e) {
    $retryAfter = $e->getRetryAfter(); // seconds, or null
} catch (AuthenticationException $e) {
    // Check your API key
} catch (ApiException $e) {
    $e->getStatusCode();   // int
    $e->getMessage();      // clean, developer-friendly message
    $e->getResponseBody(); // raw response body
    $e->getHeaders();      // response headers
}
```

## Testing

The SDK accepts an injectable Guzzle client, making it trivial to mock API
responses in your tests without hitting the network:

```php
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use MailerMine\Client;

$mock = new MockHandler([
    new GuzzleResponse(200, [], json_encode([
        'success' => true,
        'data'    => ['uuid' => 'msg_123'],
    ])),
]);

$http = new GuzzleClient(['handler' => HandlerStack::create($mock)]);
$mm   = new Client('test-key', 'https://mailermine.com/api/v1', $http);

$response = $mm->emails()->send([
    'from'    => 'hello@mailermine.com',
    'to'      => 'john@example.com',
    'subject' => 'Test',
    'html'    => '<p>Test</p>',
]);

// $response->data()['uuid'] === 'msg_123'
```

To run the package's own test suite:

```bash
composer test        # PHPUnit
composer test:lint   # Laravel Pint (code style)
composer analyse     # PHPStan (level 8)
composer check       # all of the above
```

## Available Resources

| Accessor              | Description                                             |
| --------------------- | ------------------------------------------------------ |
| `emails()`            | Transactional email + message lookups                  |
| `domains()`           | Sending domains, DNS records, verification             |
| `templates()`         | Reusable email templates                               |
| `campaigns()`         | Campaigns, scheduling, lifecycle, analytics, events    |
| `contacts()`          | Contacts and subscription state                        |
| `lists()`             | Static contact lists                                   |
| `audiences()`         | Lists and segments as unified audiences                |
| `segments()`          | Dynamic, rule-based segments                           |
| `tags()`              | Contact tags                                           |
| `imports()`           | CSV / bulk contact imports                             |
| `exports()`           | Contact / data exports                                 |
| `analytics()`         | Account-wide analytics                                 |
| `events()`            | Message event stream and timelines                     |
| `messages()`          | Delivery logs                                          |
| `webhooks()`          | Webhooks, deliveries, and event replay                 |
| `suppressions()`      | Suppression list management                            |
| `projects()`          | Projects                                               |
| `apiKeys()`           | API key management                                     |

Runnable examples for the most common workflows live in the
[`examples/`](examples) directory.

## Contributing

Contributions are welcome! Please read the [Contributing guide](CONTRIBUTING.md)
before opening a pull request. Note that the `generated/` directory is produced
from the OpenAPI specification and must not be edited by hand.

## Security

If you discover a security vulnerability, please review our
[Security Policy](SECURITY.md) and report it privately. Do **not** open a public
issue.

## Support

- 📖 Documentation: [`docs/`](docs) · <https://mailermine.com/docs/sdk/php>
- 💬 Discussions: <https://github.com/rahulyadav5192/mailermine-laravel-sdk/discussions>
- 🐛 Issues: <https://github.com/rahulyadav5192/mailermine-laravel-sdk/issues>
- 📦 Packagist: <https://packagist.org/packages/mailermine/mailermine>
- ✉️ Email: <support@mailermine.com>

## License

The MIT License (MIT). Please see the [License File](LICENSE) for more
information.
