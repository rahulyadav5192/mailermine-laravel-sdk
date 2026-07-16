<?php

declare(strict_types=1);

/**
 * Manage sending domains and inspect DNS configuration.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/domains.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    $domain = $mm->domains()->create([
        'domain' => 'mail.example.com',
    ]);

    $domainId = $domain->data()['id'];
    echo 'Created domain: '.$domainId.PHP_EOL;

    echo PHP_EOL.'Add these DNS records to verify the domain:'.PHP_EOL;
    foreach ($mm->domains()->dnsRecords($domainId) as $record) {
        printf('  %-6s %-40s %s%s', $record['type'] ?? '?', $record['name'] ?? '?', $record['value'] ?? '?', PHP_EOL);
    }

    $status = $mm->domains()->verify($domainId);
    echo PHP_EOL.'Verification status: '.($status->data()['status'] ?? 'pending').PHP_EOL;

    echo PHP_EOL.'All domains:'.PHP_EOL;
    foreach ($mm->domains()->list() as $item) {
        echo '  - '.($item['domain'] ?? '?').' ('.($item['status'] ?? '?').')'.PHP_EOL;
    }
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
