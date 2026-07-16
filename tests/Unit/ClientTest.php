<?php

declare(strict_types=1);

namespace MailerMine\Tests\Unit;

use InvalidArgumentException;
use MailerMine\Client;
use MailerMine\Config\Configuration;
use MailerMine\Resources\Emails;
use MailerMine\Tests\TestCase;

final class ClientTest extends TestCase
{
    public function test_it_can_be_constructed_with_an_api_key(): void
    {
        $client = new Client('test-api-key');

        $this->assertSame('test-api-key', $client->configuration()->apiKey());
        $this->assertInstanceOf(Emails::class, $client->emails());
    }

    public function test_it_can_be_constructed_with_configuration(): void
    {
        $config = new Configuration(
            apiKey: 'cfg-key',
            baseUrl: 'https://example.test/api/v1',
        );

        $client = new Client($config);

        $this->assertSame('cfg-key', $client->configuration()->apiKey());
        $this->assertSame('https://example.test/api/v1', $client->configuration()->baseUrl());
        $this->assertSame(
            'https://example.test/api/v1',
            $client->generatedConfiguration()->getHost()
        );
    }

    public function test_it_rejects_an_empty_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Client('');
    }

    public function test_resource_accessors_are_lazy_and_memoized(): void
    {
        $client = new Client('test-api-key');

        $emailsA = $client->emails();
        $emailsB = $client->emails();

        $this->assertSame($emailsA, $emailsB);
        $this->assertInstanceOf(Emails::class, $client->emails());
        $this->assertNotNull($client->domains());
        $this->assertNotNull($client->templates());
        $this->assertNotNull($client->projects());
        $this->assertNotNull($client->apiKeys());
        $this->assertNotNull($client->contacts());
        $this->assertNotNull($client->lists());
        $this->assertNotNull($client->segments());
        $this->assertNotNull($client->campaigns());
        $this->assertNotNull($client->analytics());
        $this->assertNotNull($client->webhooks());
        $this->assertNotNull($client->suppressions());
        $this->assertNotNull($client->imports());
        $this->assertNotNull($client->exports());
        $this->assertNotNull($client->tags());
        $this->assertNotNull($client->audiences());
        $this->assertNotNull($client->messages());
        $this->assertNotNull($client->events());
    }

    public function test_generated_configuration_uses_bearer_access_token(): void
    {
        $client = new Client('secret-token');

        $this->assertSame('secret-token', $client->generatedConfiguration()->getAccessToken());
        $this->assertSame(
            Configuration::DEFAULT_USER_AGENT,
            $client->generatedConfiguration()->getUserAgent()
        );
    }
}
