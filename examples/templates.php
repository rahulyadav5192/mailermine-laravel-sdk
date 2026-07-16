<?php

declare(strict_types=1);

/**
 * Create, preview, and send with templates.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/templates.php
 */

require __DIR__.'/../vendor/autoload.php';

use MailerMine\Client;
use MailerMine\Exceptions\ApiException;

$mm = new Client(
    getenv('MAILERMINE_API_KEY') ?: throw new RuntimeException('MAILERMINE_API_KEY is required.'),
    getenv('MAILERMINE_BASE_URL') ?: null,
);

try {
    $template = $mm->templates()->create([
        'name' => 'Welcome Email',
        'subject' => 'Welcome {{first_name}}',
        'html' => '<h1>Welcome {{first_name}}!</h1><p>Great to have you.</p>',
        'text' => 'Welcome {{first_name}}! Great to have you.',
    ]);

    $templateId = $template->data()['id'];
    echo 'Created template: '.$templateId.PHP_EOL;

    $preview = $mm->templates()->preview($templateId, [
        'first_name' => 'John',
    ]);
    echo 'Preview subject: '.($preview->data()['subject'] ?? '').PHP_EOL;

    // Send an email using the template.
    $email = $mm->emails()->send([
        'from' => 'hello@mailermine.com',
        'to' => 'john@example.com',
        'template_id' => $templateId,
        'variables' => ['first_name' => 'John'],
    ]);
    echo 'Queued templated email: '.$email->data()['uuid'].PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
