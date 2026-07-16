<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$logs = $mm->messages()->list([
    'status' => getenv('MAILERMINE_STATUS') ?: 'delivered',
    'from' => getenv('MAILERMINE_FROM') ?: '2026-01-01',
    'page' => 1,
    'per_page' => 25,
]);

printf("Found %d delivery logs (page %d)\n", $logs->count(), $logs->pagination()?->currentPage ?? 1);

foreach ($logs as $log) {
    printf("%s  %s  %s\n", $log['id'] ?? '', $log['status'] ?? '', $log['to'] ?? '');
}

if ($logs->isNotEmpty()) {
    $firstId = $logs->first()['id'];
    $detail = $mm->messages()->get($firstId);
    printf("\nDetail status for %s: %s\n", $firstId, $detail->data()['status'] ?? '');
}

$search = $mm->messages()->search(getenv('MAILERMINE_SEARCH') ?: 'example.com');
printf("\nSearch matches: %d\n", $search->count());
