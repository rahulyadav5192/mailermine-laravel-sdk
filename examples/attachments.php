<?php

declare(strict_types=1);

/**
 * Send an email with a file attachment.
 *
 * Attachment content must be Base64 encoded.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/attachments.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$file = __DIR__.'/invoice.pdf';

if (!is_file($file)) {
    fwrite(STDERR, "Place a file at {$file} before running this example.".PHP_EOL);
    exit(1);
}

try {
    $email = $mm->emails()->send([
        'from' => 'billing@mailermine.com',
        'to' => 'john@example.com',
        'subject' => 'Your invoice',
        'html' => '<p>Your invoice is attached.</p>',
        'attachments' => [
            [
                'filename' => basename($file),
                'content' => base64_encode(
                    file_get_contents($file) ?: throw new RuntimeException("Unable to read {$file}.")
                ),
                'content_type' => 'application/pdf',
            ],
        ],
    ]);

    echo 'Queued message with attachment: '.$email->data()['uuid'].PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
