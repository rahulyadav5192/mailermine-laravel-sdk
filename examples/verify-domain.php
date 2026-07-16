<?php

declare(strict_types=1);

/**
 * Create a sending domain, print DNS records, and trigger verification.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/verify-domain.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$domainName = getenv('MAILERMINE_DOMAIN') ?: 'mail.example.com';

try {
    $domain = $mm->domains()->create([
        'domain' => $domainName,
    ]);

    $domainId = $domain->data()['id'];
    echo "Created domain {$domainName} ({$domainId})".PHP_EOL;
    echo PHP_EOL.'Add these DNS records, then re-run verification:'.PHP_EOL;

    foreach ($mm->domains()->dnsRecords($domainId) as $record) {
        printf(
            '  %-6s %-40s %s%s',
            $record['type'] ?? '?',
            $record['name'] ?? '?',
            $record['value'] ?? '?',
            PHP_EOL,
        );
    }

    $status = $mm->domains()->verify($domainId);
    echo PHP_EOL.'Verification status: '.($status->data()['status'] ?? 'pending').PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
