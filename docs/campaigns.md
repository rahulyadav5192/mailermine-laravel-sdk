# Campaigns

Create, schedule, send, and measure email campaigns with `campaigns()`.

## Create

The API create endpoint accepts a name; the SDK applies the rest of the
configuration in the same call:

```php
$campaign = $mm->campaigns()->create([
    'name'        => 'March Newsletter',
    'subject'     => "What's new this month",
    'from_name'   => 'MailerMine',
    'from_email'  => 'news@mailermine.com',
    'template_id' => $templateId,
]);

$id = $campaign->data()['uuid'];
```

## Recipients and content

```php
$mm->campaigns()->addAudience($id, $audienceId);
$mm->campaigns()->addSegment($id, $segmentId);
$count = $mm->campaigns()->recipientCount($id);

$mm->campaigns()->setTemplate($id, $templateId);
$mm->campaigns()->setSubject($id, 'A better subject');
$mm->campaigns()->setSender($id, 'news@mailermine.com', 'MailerMine');
```

## Schedule or send now

```php
$mm->campaigns()->schedule($id, [
    'scheduled_at' => '2026-08-01T09:00:00+00:00',
    'timezone'     => 'UTC',
]);

// Or send immediately
$mm->campaigns()->sendNow($id);
```

## Lifecycle

```php
$mm->campaigns()->pause($id);
$mm->campaigns()->resume($id);
$mm->campaigns()->cancel($id);
$mm->campaigns()->archive($id);
```

## Analytics and events

```php
$analytics = $mm->campaigns()->analytics($id);
$opens     = $mm->campaigns()->opens($id);
$clicks    = $mm->campaigns()->clicks($id);
$events    = $mm->campaigns()->events($id);
```

## Example

See [`examples/create-campaign.php`](../examples/create-campaign.php).
