<?php

declare(strict_types=1);

/**
 * Manage contacts: create, update, list, and subscription state.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/contacts.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    // Create or update a contact in a single call.
    $contact = $mm->contacts()->upsert([
        'email' => 'john@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'subscribed' => true,
        'custom_fields' => ['plan' => 'pro'],
    ]);

    $contactId = $contact->data()['id'];
    echo 'Upserted contact: '.$contactId.PHP_EOL;

    // Update attributes.
    $mm->contacts()->update($contactId, [
        'last_name' => 'Appleseed',
    ]);

    // List subscribed contacts with pagination.
    $contacts = $mm->contacts()->list([
        'subscribed' => true,
        'page' => 1,
        'per_page' => 25,
    ]);

    echo 'Subscribed contacts on page 1: '.$contacts->count().PHP_EOL;
    foreach ($contacts as $item) {
        echo '  - '.($item['email'] ?? '?').PHP_EOL;
    }

    if ($pagination = $contacts->pagination()) {
        echo 'Total: '.$pagination->total.' across '.$pagination->lastPage.' pages.'.PHP_EOL;
    }

    // Unsubscribe.
    $mm->contacts()->unsubscribe($contactId);
    echo 'Unsubscribed contact.'.PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
