# Analytics

Account-wide engagement metrics via `analytics()`.

## Overview

```php
$range = [
    'from' => '2026-01-01',
    'to'   => '2026-01-31',
];

$overview = $mm->analytics()->overview($range);
$data = $overview->data();

echo $data['delivered'] ?? 0;
echo $data['opens'] ?? 0;
echo $data['clicks'] ?? 0;
```

Dates accept ISO-8601 strings or `DateTimeInterface` instances.

## Metric slices

```php
$mm->analytics()->deliveries($range);
$mm->analytics()->opens($range);
$mm->analytics()->clicks($range);
$mm->analytics()->bounces($range);
$mm->analytics()->complaints($range);
$mm->analytics()->unsubscribes($range);
$mm->analytics()->usage($range);
$mm->analytics()->activity($range);
```

## Filters

```php
$mm->analytics()->opens([
    'from'        => '2026-01-01',
    'to'          => '2026-01-31',
    'campaign_id' => $campaignId,
    'project_id'  => $projectId,
    'domain_id'   => $domainId,
]);
```

## Campaign-specific analytics

Prefer `$mm->campaigns()->analytics($campaignId)` when you already have a
campaign ID. See [Campaigns](campaigns.md).

## Example

See [`examples/analytics.php`](../examples/analytics.php).
