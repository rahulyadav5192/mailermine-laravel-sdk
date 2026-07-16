<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$file = $argv[1] ?? throw new InvalidArgumentException(
    'Usage: php examples/import.php /path/to/contacts.csv'
);

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$import = $mm->imports()->create([
    'file' => $file,
]);

$importId = $import->data()['id'];
printf("Uploaded import %s\n", $importId);

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
printf("Import status: %s\n", $status->data()['status']);
