<?php

declare(strict_types=1);

namespace MailerMine\Laravel;

use Illuminate\Support\ServiceProvider;
use MailerMine\Client;
use MailerMine\Config\Configuration;
use MailerMine\Contracts\ClientContract;

final class MailerMineServiceProvider extends ServiceProvider
{
    /**
     * Register the configuration and client bindings in the container.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/mailermine.php',
            'mailermine'
        );

        $this->app->singleton(Configuration::class, function (): Configuration {
            return Configuration::fromArray([
                'api_key' => (string) config('mailermine.api_key', ''),
                'base_url' => config('mailermine.base_url'),
                'timeout' => (float) config('mailermine.timeout', 30),
            ]);
        });

        $this->app->singleton(Client::class, function ($app): Client {
            return new Client($app->make(Configuration::class));
        });

        $this->app->alias(Client::class, ClientContract::class);
        $this->app->alias(Client::class, 'mailermine');
    }

    /**
     * Publish the package configuration when running in the console.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/mailermine.php' => config_path('mailermine.php'),
            ], 'mailermine-config');
        }
    }
}
