<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$project = $mm->projects()->create([
    'name' => 'Production Mail',
    'environment' => 'production',
    'timezone' => 'UTC',
]);

printf("Created project %s\n", $project->data()['id']);

foreach ($mm->projects()->list(['status' => 'active']) as $item) {
    printf("%s  %s\n", $item['id'], $item['name']);
}
