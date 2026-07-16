<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

$rules = [
    'logic' => 'and',
    'rules' => [
        [
            'field' => 'subscribed',
            'operator' => 'equals',
            'value' => true,
        ],
    ],
];

$preview = $mm->segments()->preview(null, $rules);
printf("Preview count: %d\n", $preview->data()['count']);

$segment = $mm->segments()->create([
    'name' => 'Active subscribers',
    'description' => 'Contacts currently subscribed',
    'rules' => $rules,
]);

$segmentId = $segment->data()['id'];
printf("Created segment %s\n", $segmentId);

$savedPreview = $mm->segments()->preview($segmentId);
printf("Saved segment matches: %d\n", $savedPreview->data()['count']);
