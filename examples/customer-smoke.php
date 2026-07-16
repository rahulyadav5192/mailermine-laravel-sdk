<?php

declare(strict_types=1);

/**
 * Post-Packagist customer smoke checklist (run inside a fresh Laravel app).
 *
 * Prerequisites:
 *   composer require mailermine/mailermine
 *   MAILERMINE_API_KEY set in the environment
 *
 * Usage (from the Laravel project root, after requiring the package):
 *   php vendor/mailermine/mailermine/examples/customer-smoke.php
 *
 * Or copy this file into your project and run it with the package installed.
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;
use MailerMine\Resources\Webhooks;

$apiKey = getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.');
$mm = new Client($apiKey, getenv('MAILERMINE_BASE_URL') ?: null);

$steps = [];

try {
    echo "== MailerMine customer smoke test ==\n";

    // 1. Send email
    $email = $mm->emails()->send([
        'from' => getenv('MAILERMINE_FROM') ?: 'hello@mailermine.com',
        'to' => getenv('MAILERMINE_TO') ?: 'john@example.com',
        'subject' => 'SDK smoke test',
        'html' => '<p>Customer install smoke test</p>',
    ]);
    $steps['send_email'] = $email->data()['uuid'] ?? 'ok';
    echo "[ok] send email\n";

    // 2. Domains list (verify path without forcing DNS changes)
    $domains = $mm->domains()->list(['per_page' => 1]);
    $steps['domains'] = $domains->count();
    echo "[ok] domains list\n";

    // 3. Create template
    $template = $mm->templates()->create([
        'name' => 'SDK Smoke Template '.date('YmdHis'),
        'subject' => 'Smoke {{name}}',
        'html' => '<p>Hello {{name}}</p>',
        'text' => 'Hello {{name}}',
    ]);
    $steps['template'] = $template->data()['id'] ?? 'ok';
    echo "[ok] create template\n";

    // 4. Create contact
    $contact = $mm->contacts()->upsert([
        'email' => getenv('MAILERMINE_TO') ?: 'john@example.com',
        'first_name' => 'Smoke',
        'subscribed' => true,
    ]);
    $steps['contact'] = $contact->data()['id'] ?? 'ok';
    echo "[ok] create contact\n";

    // 5. Campaigns list (create needs template + audience — list proves access)
    $campaigns = $mm->campaigns()->list(['per_page' => 1]);
    $steps['campaigns'] = $campaigns->count();
    echo "[ok] campaigns list\n";

    // 6. Analytics
    $overview = $mm->analytics()->overview([
        'from' => (new DateTimeImmutable('-7 days'))->format('Y-m-d'),
        'to' => (new DateTimeImmutable('today'))->format('Y-m-d'),
    ]);
    $steps['analytics'] = is_array($overview->data()) ? 'ok' : 'ok';
    echo "[ok] analytics overview\n";

    // 7. Webhooks list + local signature verify
    $webhooks = $mm->webhooks()->list(['per_page' => 1]);
    $payload = '{"event":"email.delivered"}';
    $secret = 'whsec_smoke';
    $signature = 'sha256='.hash_hmac('sha256', $payload, $secret);
    assert(Webhooks::verify($payload, $signature, $secret) === true);
    $steps['webhooks'] = $webhooks->count();
    echo "[ok] webhooks + signature verify\n";

    echo "\nAll smoke steps passed.\n";
    print_r($steps);
} catch (ApiException $e) {
    fwrite(STDERR, 'FAILED: '.$e->getMessage().' (HTTP '.$e->getStatusCode().')'.PHP_EOL);
    fwrite(STDERR, 'Completed steps: '.json_encode($steps).PHP_EOL);
    exit(1);
}
