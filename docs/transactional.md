# Transactional Email

Send one-off emails with the `emails()` resource.

## Send

```php
$response = $mm->emails()->send([
    'from'     => 'hello@mailermine.com',
    'to'       => 'john@example.com',
    'subject'  => 'Your receipt',
    'html'     => '<p>Thanks for your purchase.</p>',
    'text'     => 'Thanks for your purchase.',
    'reply_to' => 'support@mailermine.com',
    'tags'     => ['receipt'],
    'metadata' => ['order_id' => 1234],
]);

$uuid = $response->data()['uuid'];
```

`to`, `cc`, and `bcc` accept a string or an array of addresses.

## Attachments

Content must be Base64 encoded:

```php
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
```

## Templates

```php
$mm->emails()->send([
    'from'        => 'hello@mailermine.com',
    'to'          => 'john@example.com',
    'template_id' => $templateId,
    'variables'   => ['first_name' => 'John'],
]);
```

## List, get, and events

```php
$recent = $mm->emails()->list(['status' => 'sent', 'page' => 1]);
$email  = $mm->emails()->get($messageId);
$events = $mm->emails()->events($messageId);
```

## Examples

- [`examples/send-email.php`](../examples/send-email.php)
- [`examples/attachments.php`](../examples/attachments.php)
- [`examples/cc-bcc.php`](../examples/cc-bcc.php)
