<?php

declare(strict_types=1);

/**
 * Send an email with CC and BCC recipients.
 *
 * `to`, `cc`, and `bcc` accept a single address or a list of addresses.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/cc-bcc.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    $email = $mm->emails()->send([
        'from' => 'sales@mailermine.com',
        'to' => 'john@example.com',
        'cc' => ['manager@example.com', 'team@example.com'],
        'bcc' => 'archive@example.com',
        'subject' => 'Your quote',
        'html' => '<p>Please find your quote below.</p>',
    ]);

    echo 'Queued message: '.$email->data()['uuid'].PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
