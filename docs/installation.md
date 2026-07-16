# Installation

Install the official MailerMine PHP & Laravel SDK with Composer.

## Requirements

| Requirement | Version |
| ----------- | ------- |
| PHP | 8.3 or 8.4 |
| Laravel (optional) | 12.x or 13.x |
| Extensions | `curl`, `json`, `mbstring` |

## Install

```bash
composer require mailermine/mailermine
```

## Laravel

The service provider and `MailerMine` facade are auto-discovered. No manual registration is required.

### Publish configuration (optional)

```bash
php artisan vendor:publish --tag=mailermine-config
```

### Environment

Add these variables to `.env`:

```dotenv
MAILERMINE_API_KEY=your-api-key
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
MAILERMINE_TIMEOUT=30
```

### Verify the install

```php
use MailerMine\Facades\MailerMine;

MailerMine::emails(); // resolves without errors
```

## Pure PHP

```php
require __DIR__.'/vendor/autoload.php';

use MailerMine\Client;

$mm = new Client(getenv('MAILERMINE_API_KEY'));
```

Optional custom base URL (self-hosted or staging):

```php
$mm = new Client('your-api-key', 'https://mailermine.com/api/v1');
```

## Next steps

- [Quick start](quick-start.md)
- [Authentication](authentication.md)
- [Send your first email](transactional.md)
