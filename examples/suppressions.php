<?php

declare(strict_types=1);

/**
 * Manage the suppression list.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/suppressions.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    // Check whether an address is suppressed before sending.
    $check = $mm->suppressions()->check('john@example.com');
    $isSuppressed = (bool) ($check->data()['suppressed'] ?? false);
    echo 'john@example.com suppressed? '.($isSuppressed ? 'yes' : 'no').PHP_EOL;

    if (!$isSuppressed) {
        $suppression = $mm->suppressions()->add([
            'email' => 'john@example.com',
            'reason' => 'manual',
            'notes' => 'Requested removal via support ticket #123',
        ]);
        echo 'Added suppression: '.($suppression->data()['id'] ?? '?').PHP_EOL;
    }

    echo PHP_EOL.'Current suppressions:'.PHP_EOL;
    foreach ($mm->suppressions()->list(['per_page' => 10]) as $item) {
        echo '  - '.($item['email'] ?? '?').' ('.($item['reason'] ?? '?').')'.PHP_EOL;
    }
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
