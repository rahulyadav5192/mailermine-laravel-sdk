<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$list = $mm->lists()->create([
    'name' => 'Newsletter',
    'description' => 'Weekly product updates',
]);

$listId = $list->data()['id'];
printf("Created list %s\n", $listId);

$contact = $mm->contacts()->upsert([
    'email' => 'subscriber@example.com',
    'first_name' => 'Sam',
    'subscribed' => true,
]);

$mm->lists()->addContact($listId, $contact->data()['id']);
printf("Added contact %s to list\n", $contact->data()['id']);

foreach ($mm->lists()->list() as $item) {
    printf("%s  %s\n", $item['id'], $item['name']);
}
