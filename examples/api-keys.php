<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$projectId = $argv[1] ?? throw new InvalidArgumentException(
    'Usage: php examples/api-keys.php <project-uuid>'
);

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$key = $mm->apiKeys()->create($projectId, [
    'name' => 'Production sender',
    'scopes' => ['emails.send'],
]);

printf("Created key %s\n", $key->data()['id']);
printf("Secret (store it now): %s\n", $key->data()['secret']);

foreach ($mm->apiKeys()->list($projectId) as $item) {
    printf("%s  %s  %s\n", $item['id'], $item['name'], $item['status']);
}
