<?php

declare(strict_types=1);

use MailerMine\Client;
use MailerMine\Contracts\ClientContract;

if (!function_exists('mailermine')) {
    /**
     * Resolve the MailerMine client from Laravel's service container.
     *
     * A convenient alternative to the `MailerMine` facade and constructor
     * injection. The returned client is the shared singleton registered by
     * {@see MailerMine\Laravel\MailerMineServiceProvider}.
     *
     * @return ClientContract The shared MailerMine client instance.
     *
     * @throws RuntimeException When called outside a Laravel application.
     *
     * @example
     * mailermine()->emails()->send([
     *     'from' => 'hello@mailermine.com',
     *     'to' => 'john@example.com',
     *     'subject' => 'Hello',
     *     'html' => '<h1>Hello</h1>',
     * ]);
     */
    function mailermine(): ClientContract
    {
        if (!function_exists('app')) {
            throw new RuntimeException(
                'The mailermine() helper requires a Laravel application. '
                .'Outside Laravel, instantiate MailerMine\\Client directly.'
            );
        }

        return app(Client::class);
    }
}
