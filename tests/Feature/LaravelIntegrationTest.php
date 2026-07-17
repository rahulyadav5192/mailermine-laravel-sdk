<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Client;
use MailerMine\Config\Configuration;
use MailerMine\Contracts\ClientContract;
use MailerMine\Facades\MailerMine;
use MailerMine\Laravel\MailerMineServiceProvider;
use MailerMine\Resources\Emails;
use Orchestra\Testbench\TestCase;

final class LaravelIntegrationTest extends TestCase
{
    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [MailerMineServiceProvider::class];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<string, class-string>
     */
    protected function getPackageAliases($app): array
    {
        return ['MailerMine' => MailerMine::class];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('mailermine.api_key', 'test-laravel-key');
        $app['config']->set('mailermine.base_url', 'https://example.test/api/v1');
        $app['config']->set('mailermine.timeout', 15);
    }

    public function test_the_config_file_is_merged(): void
    {
        self::assertSame('test-laravel-key', config('mailermine.api_key'));
        self::assertSame('https://example.test/api/v1', config('mailermine.base_url'));
    }

    public function test_the_client_is_registered_as_a_singleton(): void
    {
        $a = $this->app->make(Client::class);
        $b = $this->app->make(Client::class);

        self::assertInstanceOf(Client::class, $a);
        self::assertSame($a, $b);
    }

    public function test_the_client_is_configured_from_the_config(): void
    {
        $client = $this->app->make(Client::class);

        self::assertSame('test-laravel-key', $client->configuration()->apiKey());
        self::assertSame('https://example.test/api/v1', $client->configuration()->baseUrl());
        self::assertSame(15.0, $client->configuration()->timeout());
    }

    public function test_the_configuration_is_bound_as_a_singleton(): void
    {
        self::assertInstanceOf(Configuration::class, $this->app->make(Configuration::class));
        self::assertSame(
            $this->app->make(Configuration::class),
            $this->app->make(Configuration::class),
        );
    }

    public function test_the_contract_and_alias_resolve_to_the_client(): void
    {
        self::assertInstanceOf(Client::class, $this->app->make(ClientContract::class));
        self::assertInstanceOf(Client::class, $this->app->make('mailermine'));
        self::assertSame(
            $this->app->make(Client::class),
            $this->app->make(ClientContract::class),
        );
    }

    public function test_the_facade_resolves_resources(): void
    {
        self::assertInstanceOf(Emails::class, MailerMine::emails());
        self::assertSame(
            $this->app->make(Client::class)->emails(),
            MailerMine::emails(),
        );
    }

    public function test_the_mailermine_helper_resolves_the_shared_client(): void
    {
        self::assertTrue(function_exists('mailermine'));
        self::assertInstanceOf(Client::class, mailermine());
        self::assertSame($this->app->make(Client::class), mailermine());
        self::assertInstanceOf(Emails::class, mailermine()->emails());
    }

    public function test_the_config_file_is_publishable(): void
    {
        $paths = MailerMineServiceProvider::pathsToPublish(
            MailerMineServiceProvider::class,
            'mailermine-config',
        );

        self::assertNotEmpty($paths);
        self::assertContains('mailermine.php', array_map(
            static fn (string $target): string => basename($target),
            array_values($paths),
        ));
    }
}
