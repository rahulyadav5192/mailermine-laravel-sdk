<?php

declare(strict_types=1);

namespace MailerMine\Tests\Unit;

use InvalidArgumentException;
use MailerMine\Config\Configuration;
use MailerMine\Tests\TestCase;

final class ConfigurationTest extends TestCase
{
    public function test_it_builds_from_an_array_with_snake_case_keys(): void
    {
        $config = Configuration::fromArray([
            'api_key' => 'key-123',
            'base_url' => 'https://example.test/api/v1',
            'timeout' => 12,
            'user_agent' => 'my-app/2.0',
            'debug' => true,
        ]);

        self::assertSame('key-123', $config->apiKey());
        self::assertSame('https://example.test/api/v1', $config->baseUrl());
        self::assertSame(12.0, $config->timeout());
        self::assertSame('my-app/2.0', $config->userAgent());
        self::assertTrue($config->debug());
    }

    public function test_it_builds_from_an_array_with_camel_case_keys(): void
    {
        $config = Configuration::fromArray([
            'apiKey' => 'key-123',
            'baseUrl' => 'https://example.test/api/v1',
            'userAgent' => 'camel/1.0',
        ]);

        self::assertSame('key-123', $config->apiKey());
        self::assertSame('https://example.test/api/v1', $config->baseUrl());
        self::assertSame('camel/1.0', $config->userAgent());
    }

    public function test_it_falls_back_to_the_default_base_url(): void
    {
        $config = new Configuration(apiKey: 'key-123');

        self::assertSame(Configuration::DEFAULT_BASE_URL, $config->baseUrl());
        self::assertSame(Configuration::DEFAULT_USER_AGENT, $config->userAgent());
        self::assertSame(30.0, $config->timeout());
        self::assertFalse($config->debug());
    }

    public function test_it_rejects_an_empty_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Configuration(apiKey: '');
    }

    public function test_from_array_rejects_a_missing_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Configuration::fromArray([]);
    }

    public function test_it_rejects_a_non_positive_timeout(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Configuration(apiKey: 'key-123', timeout: 0.0);
    }

    public function test_it_builds_the_generated_configuration(): void
    {
        $generated = (new Configuration(
            apiKey: 'secret',
            baseUrl: 'https://example.test/api/v1/',
            userAgent: 'ua/1.0',
        ))->toGenerated();

        self::assertSame('secret', $generated->getAccessToken());
        self::assertSame('ua/1.0', $generated->getUserAgent());
        // Trailing slash is trimmed from the host.
        self::assertSame('https://example.test/api/v1', $generated->getHost());
    }

    public function test_generated_configuration_uses_the_default_host_when_unset(): void
    {
        $generated = (new Configuration(apiKey: 'secret'))->toGenerated();

        self::assertSame(Configuration::DEFAULT_BASE_URL, $generated->getHost());
    }
}
