<?php

declare(strict_types=1);

/**
 * Send a transactional email.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/send-email.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\ValidationException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    $email = $mm->emails()->send([
        'from' => 'MailerMine <hello@mailermine.com>',
        'to' => 'john@example.com',
        'subject' => 'Hello from MailerMine',
        'html' => '<h1>Hello!</h1><p>Sent with the MailerMine PHP SDK.</p>',
        'text' => 'Hello! Sent with the MailerMine PHP SDK.',
        'tags' => ['example'],
    ]);

    echo 'Queued message: '.$email->data()['uuid'].PHP_EOL;
} catch (ValidationException $e) {
    fwrite(STDERR, 'Validation failed:'.PHP_EOL);
    foreach ($e->getErrors() as $field => $messages) {
        fwrite(STDERR, sprintf('  - %s: %s', $field, implode(', ', (array) $messages)).PHP_EOL);
    }
    exit(1);
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
