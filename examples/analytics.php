<?php

declare(strict_types=1);

/**
 * Read account analytics over a date range.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/analytics.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$range = [
    'from' => (new DateTimeImmutable('-30 days'))->format('Y-m-d'),
    'to' => (new DateTimeImmutable('today'))->format('Y-m-d'),
];

try {
    $overview = $mm->analytics()->overview($range);
    $data = $overview->data();

    echo 'Analytics for the last 30 days'.PHP_EOL;
    echo str_repeat('-', 32).PHP_EOL;
    printf('Delivered:    %d%s', $data['delivered'] ?? 0, PHP_EOL);
    printf('Opens:        %d%s', $data['opens'] ?? 0, PHP_EOL);
    printf('Clicks:       %d%s', $data['clicks'] ?? 0, PHP_EOL);
    printf('Bounces:      %d%s', $data['bounces'] ?? 0, PHP_EOL);
    printf('Complaints:   %d%s', $data['complaints'] ?? 0, PHP_EOL);

    // Individual metric slices are also available.
    $opens = $mm->analytics()->opens($range);
    echo PHP_EOL.'Opens metric payload: '.json_encode($opens->data()).PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
