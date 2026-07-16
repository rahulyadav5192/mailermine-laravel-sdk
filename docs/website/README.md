# Website Integration Package

Copy-ready content for [mailermine.com](https://mailermine.com) documentation pages
about the official PHP & Laravel SDK.

## Page: Official Laravel SDK

**Title:** Official PHP & Laravel SDK

**Intro:**

> The official MailerMine PHP & Laravel SDK lets you send transactional email,
> run campaigns, manage contacts, and read analytics with a clean, typed API.
> It works with Laravel 12/13 out of the box and in any PHP 8.3+ project.

**Primary CTA:** Install with Composer

```bash
composer require mailermine/mailermine
```

**Links**

| Label | URL |
| ----- | --- |
| GitHub | https://github.com/rahulyadav5192/mailermine-laravel-sdk |
| Packagist | https://packagist.org/packages/mailermine/mailermine |
| Changelog | https://github.com/rahulyadav5192/mailermine-laravel-sdk/blob/main/CHANGELOG.md |
| Supported versions | https://github.com/rahulyadav5192/mailermine-laravel-sdk/blob/main/SUPPORTED_VERSIONS.md |

## Installation guide (website snippet)

```bash
composer require mailermine/mailermine
php artisan vendor:publish --tag=mailermine-config
```

```dotenv
MAILERMINE_API_KEY=your-api-key
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
```

```php
use MailerMine\Facades\MailerMine;

MailerMine::emails()->send([
    'from'    => 'hello@mailermine.com',
    'to'      => 'john@example.com',
    'subject' => 'Hello',
    'html'    => '<p>Hello from MailerMine</p>',
]);
```

## API examples (website cards)

### Send email

```php
MailerMine::emails()->send([
    'from' => 'hello@mailermine.com',
    'to' => 'john@example.com',
    'subject' => 'Welcome',
    'html' => '<h1>Welcome</h1>',
]);
```

### Verify domain

```php
MailerMine::domains()->verify($domainId);
```

### Create campaign

```php
MailerMine::campaigns()->create([
    'name' => 'March Newsletter',
    'subject' => 'What is new',
    'template_id' => $templateId,
]);
```

### Webhooks

```php
use MailerMine\Resources\Webhooks;

Webhooks::verify($payload, $signature, $secret);
```

## Version support table

| SDK | PHP | Laravel | Status |
| --- | --- | ------- | ------ |
| 1.x | 8.3, 8.4 | 12.x, 13.x | Active |

## Release notes blurb (v1.0.0)

> **v1.0.0** — Initial public release. Full coverage of the MailerMine API:
> transactional email, domains, templates, contacts, campaigns, analytics,
> webhooks, and suppressions. PHPStan level 8, Laravel Pint, and CI across
> PHP 8.3/8.4 and Laravel 12/13.

## Suggested nav

- Developers → PHP & Laravel SDK
- Developers → Installation
- Developers → Examples
- Developers → GitHub
- Developers → Packagist
- Developers → Release notes
