<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$messageId = $argv[1] ?? getenv('MAILERMINE_MESSAGE_ID') ?: throw new InvalidArgumentException(
    'Usage: php examples/events.php <message-uuid>'
);

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$message = $mm->events()->message($messageId);
printf("Message status: %s\n", $message->data()['status'] ?? '');

echo "Timeline\n";
foreach ($mm->events()->timeline($messageId) as $event) {
    printf("- %s\n", $event['event_type'] ?? json_encode($event, JSON_THROW_ON_ERROR));
}

echo "\nRecent opens\n";
foreach ($mm->events()->list([
    'event_type' => 'email.opened',
    'from' => getenv('MAILERMINE_FROM') ?: '2026-01-01',
]) as $event) {
    printf("- %s\n", $event['id'] ?? '');
}
