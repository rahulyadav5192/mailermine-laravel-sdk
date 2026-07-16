<?php

declare(strict_types=1);

/**
 * Create, configure, schedule, and send an email campaign, then read results.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/campaigns.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$templateId = getenv('MAILERMINE_TEMPLATE_ID') ?: 'your-template-id';
$audienceId = getenv('MAILERMINE_AUDIENCE_ID') ?: 'your-audience-id';

try {
    // Create a fully configured draft campaign in one call.
    $campaign = $mm->campaigns()->create([
        'name' => 'March Newsletter',
        'subject' => 'What is new this month',
        'from_name' => 'MailerMine',
        'from_email' => 'news@mailermine.com',
        'template_id' => $templateId,
    ]);

    $campaignId = $campaign->data()['uuid'] ?? $campaign->data()['id'];
    echo 'Created campaign: '.$campaignId.PHP_EOL;

    // Attach recipients and preview the audience size.
    $mm->campaigns()->addAudience($campaignId, $audienceId);
    $count = $mm->campaigns()->recipientCount($campaignId);
    echo 'Recipients: '.($count->data()['count'] ?? 0).PHP_EOL;

    // Option A — schedule for later.
    $mm->campaigns()->schedule($campaignId, [
        'scheduled_at' => (new DateTimeImmutable('+1 day'))->format(DateTimeInterface::ATOM),
        'timezone' => 'UTC',
    ]);
    echo 'Campaign scheduled.'.PHP_EOL;

    // Option B — send immediately (uncomment to use):
    // $mm->campaigns()->sendNow($campaignId);

    // Read analytics and recent events once the campaign is sending.
    $analytics = $mm->campaigns()->analytics($campaignId);
    $data = $analytics->data();
    printf(
        'Sent: %d | Opens: %d | Clicks: %d%s',
        $data['sent'] ?? 0,
        $data['opens'] ?? 0,
        $data['clicks'] ?? 0,
        PHP_EOL,
    );

    foreach ($mm->campaigns()->events($campaignId) as $event) {
        echo '  - '.($event['event_type'] ?? '?').' @ '.($event['created_at'] ?? '?').PHP_EOL;
    }
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
