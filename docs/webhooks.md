# Webhooks

Receive MailerMine events in your application with `webhooks()`.

## Create

```php
$webhook = $mm->webhooks()->create([
    'name'              => 'Production events',
    'url'               => 'https://example.com/webhooks/mailermine',
    'subscribed_events' => [
        'email.delivered',
        'email.opened',
        'email.bounced',
    ],
]);

// Signing secret is returned only on create/rotate — store it now.
$secret = $webhook->data()['secret'];
$id     = $webhook->data()['id'];
```

## Manage

```php
$mm->webhooks()->list();
$mm->webhooks()->update($id, ['is_active' => false]);
$mm->webhooks()->rotateSecret($id);
$mm->webhooks()->test($id);
$mm->webhooks()->delete($id);
```

## Deliveries and replay

```php
$mm->webhooks()->deliveries($id);
$mm->webhooks()->failures($id);
$mm->webhooks()->replay($id);
$mm->webhooks()->retry($deliveryId);
```

## Verify signatures

MailerMine signs each payload with HMAC-SHA256. Always verify before trusting
the body:

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

### Laravel controller

```php
use Illuminate\Http\Request;
use MailerMine\Resources\Webhooks;

public function handle(Request $request)
{
    abort_unless(
        Webhooks::verify(
            $request->getContent(),
            $request->header('X-MailerMine-Signature', ''),
            config('services.mailermine.webhook_secret'),
        ),
        401,
    );

    // Handle $request->json()->all()
}
```

## Example

See [`examples/webhooks.php`](../examples/webhooks.php).
