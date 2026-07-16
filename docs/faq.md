# FAQ

## Does the SDK require Laravel?

No. Laravel is optional. The same package works in any PHP 8.3+ project. The
service provider and facade load only when Laravel is present.

## Which PHP and Laravel versions are supported?

| SDK | PHP | Laravel |
| --- | --- | ------- |
| 1.x | 8.3, 8.4 | 12.x, 13.x |

See [SUPPORTED_VERSIONS.md](../SUPPORTED_VERSIONS.md).

## Do I need to use classes from `generated/`?

No. Never reference `OpenAPI\Client\*` from application code. Use only the
`MailerMine\*` public API (`Client`, resources, `Response`, `Collection`,
exceptions).

## How do I get the message ID after sending?

```php
$uuid = $mm->emails()->send([...])->data()['uuid'];
```

## How do I paginate contacts?

```php
$page = 1;
do {
    $contacts = $mm->contacts()->list(['page' => $page, 'per_page' => 100]);
    foreach ($contacts as $contact) { /* ... */ }
    $meta = $contacts->pagination();
    $page++;
} while ($meta && $meta->hasMorePages());
```

## How do I handle rate limits?

Catch `RateLimitException` and honour `getRetryAfter()`:

```php
use MailerMine\Exceptions\RateLimitException;

try {
    $mm->emails()->send([...]);
} catch (RateLimitException $e) {
    sleep($e->getRetryAfter() ?? 60);
}
```

## Can I inject a custom HTTP client?

Yes — useful for testing:

```php
$mm = new MailerMine\Client('key', 'https://mailermine.com/api/v1', $guzzleClient);
```

## Where is the changelog?

See [CHANGELOG.md](../CHANGELOG.md).

## How do I report a security issue?

Follow [SECURITY.md](../SECURITY.md). Do not open a public GitHub issue.
