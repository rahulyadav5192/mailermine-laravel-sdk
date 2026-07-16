<?php

declare(strict_types=1);

/**
 * Create a webhook and verify an incoming signature.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/webhooks.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;
use MailerMine\Resources\Webhooks;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    $webhook = $mm->webhooks()->create([
        'name' => 'Production events',
        'url' => 'https://example.com/webhooks/mailermine',
        'subscribed_events' => ['email.delivered', 'email.opened', 'email.bounced'],
    ]);

    // The signing secret is only returned on create/rotate — store it now.
    $secret = $webhook->data()['secret'] ?? '';
    echo 'Created webhook: '.($webhook->data()['id'] ?? '?').PHP_EOL;
    echo 'Signing secret (store securely): '.$secret.PHP_EOL;

    // Inspect recent deliveries and failures.
    foreach ($mm->webhooks()->failures($webhook->data()['id']) as $failure) {
        echo '  failed delivery: '.($failure['id'] ?? '?').PHP_EOL;
    }
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}

/*
 * In your webhook controller, verify the signature before trusting the payload.
 * The example below shows the verification step in isolation.
 */
$payload = '{"event":"email.delivered"}';
$secret = 'whsec_example';
$signature = 'sha256='.hash_hmac('sha256', $payload, $secret);

if (Webhooks::verify($payload, $signature, $secret)) {
    echo PHP_EOL.'Signature is valid — safe to process.'.PHP_EOL;
} else {
    echo PHP_EOL.'Invalid signature — reject the request.'.PHP_EOL;
}
