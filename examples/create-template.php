<?php

declare(strict_types=1);

/**
 * Create an email template and preview it with sample variables.
 *
 * Usage:
 *   MAILERMINE_API_KEY=your-key php examples/create-template.php
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
        'html' => '<h1>Welcome {{first_name}}!</h1><p>Thanks for joining us.</p>',
        'text' => 'Welcome {{first_name}}! Thanks for joining us.',
    ]);

    $templateId = $template->data()['id'];
    echo 'Created template: '.$templateId.PHP_EOL;

    $preview = $mm->templates()->preview($templateId, [
        'first_name' => 'John',
    ]);

    echo 'Preview subject: '.($preview->data()['subject'] ?? '').PHP_EOL;
} catch (ApiException $e) {
    fwrite(STDERR, 'MailerMine API error ('.$e->getStatusCode().'): '.$e->getMessage().PHP_EOL);
    exit(1);
}
