<?php

declare(strict_types=1);

/**
 * Upload, configure, and start a contact import.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/import-contacts.php /path/to/contacts.csv
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$file = $argv[1] ?? null;

if ($file === null || !is_file($file)) {
    fwrite(STDERR, 'Usage: php examples/import-contacts.php /path/to/contacts.csv'.PHP_EOL);
    exit(1);
}

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    $import = $mm->imports()->create([
        'file' => $file,
    ]);

    $importId = $import->data()['id'];
    echo "Uploaded import: {$importId}".PHP_EOL;

    $mm->imports()->configure($importId, [
        'field_mappings' => [
            'email' => 'email',
            'first_name' => 'first_name',
            'last_name' => 'last_name',
        ],
        'duplicate_strategy' => 'update',
    ]);

    $mm->imports()->start($importId);

    $status = $mm->imports()->status($importId);
    echo 'Import status: '.($status->data()['status'] ?? 'unknown').PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
