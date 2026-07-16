<?php

declare(strict_types=1);

/**
 * Create a campaign, attach an audience, and schedule it.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key \
 *   MAILERMINE_TEMPLATE_ID=... \
 *   MAILERMINE_AUDIENCE_ID=... \
 *   php examples/create-campaign.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$templateId = getenv('MAILERMINE_TEMPLATE_ID') ?: throw new RuntimeException('MAILERMINE_TEMPLATE_ID is required.');
$audienceId = getenv('MAILERMINE_AUDIENCE_ID') ?: throw new RuntimeException('MAILERMINE_AUDIENCE_ID is required.');

try {
    $campaign = $mm->campaigns()->create([
        'name' => 'SDK Example Campaign',
        'subject' => 'Hello from MailerMine',
        'from_name' => 'MailerMine',
        'from_email' => 'news@mailermine.com',
        'template_id' => $templateId,
    ]);

    $campaignId = $campaign->data()['uuid'] ?? $campaign->data()['id'];
    echo 'Created campaign: '.$campaignId.PHP_EOL;

    $mm->campaigns()->addAudience($campaignId, $audienceId);
    $count = $mm->campaigns()->recipientCount($campaignId);
    echo 'Recipients: '.($count->data()['count'] ?? 0).PHP_EOL;

    $mm->campaigns()->schedule($campaignId, [
        'scheduled_at' => (new DateTimeImmutable('+1 day'))->format(DateTimeInterface::ATOM),
        'timezone' => 'UTC',
    ]);

    echo 'Campaign scheduled.'.PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
