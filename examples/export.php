<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$output = $argv[1] ?? 'contacts-export.csv';

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$export = $mm->exports()->create([
    'subscribed' => true,
]);

$exportId = $export->data()['id'];
printf("Queued export %s\n", $exportId);

do {
    sleep(1);
    $status = $mm->exports()->status($exportId);
    $state = $status->data()['status'];
    printf("Status: %s\n", $state);
} while (!in_array($state, ['completed', 'failed', 'cancelled'], true));

if ($state !== 'completed') {
    throw new RuntimeException(sprintf('Export finished with status [%s].', $state));
}

$csv = $mm->exports()->download($exportId);
file_put_contents($output, $csv->data());

printf("Saved export to %s\n", $output);
