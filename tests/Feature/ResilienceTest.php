<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as HttpResponse;
use MailerMine\Client;
use MailerMine\Config\Configuration;
use MailerMine\Exceptions\MissingScopeException;
use MailerMine\Exceptions\PlanException;
use MailerMine\Exceptions\RateLimitException;
use MailerMine\Http\HttpStack;
use MailerMine\Support\Scope;
use MailerMine\Tests\TestCase;

final class ResilienceTest extends TestCase
{
    /**
     * @param  list<mixed>  $queue
     * @param  array<int, array<string, mixed>>  $history
     */
    private function client(array $queue, array &$history = [], int $maxRetries = 2, float $maxRetryDelay = 0.0): Client
    {
        $configuration = new Configuration(
            apiKey: 'test-api-key',
            baseUrl: 'https://api.example.test/api/v1',
            maxRetries: $maxRetries,
            maxRetryDelay: $maxRetryDelay,
        );

        $stack = HttpStack::create($configuration);
        $stack->setHandler(new MockHandler($queue));
        // History innermost so every attempt (including retries) is recorded.
        $stack->push(Middleware::history($history));

        return new Client($configuration, null, new GuzzleClient(['handler' => $stack, 'http_errors' => false]));
    }

    private function json(int $status, array $body = [], array $headers = []): HttpResponse
    {
        return new HttpResponse($status, ['Content-Type' => 'application/json', ...$headers], json_encode($body, JSON_THROW_ON_ERROR));
    }

    private function sent(): HttpResponse
    {
        return $this->json(202, ['success' => true, 'data' => ['id' => 'msg_1']], [
            'X-RateLimit-Limit' => '600',
            'X-RateLimit-Remaining' => '599',
            'X-RateLimit-Reset' => (string) (time() + 30),
        ]);
    }

    /** @return array<string, mixed> */
    private function email(): array
    {
        return ['from' => 'hi@example.com', 'to' => 'user@example.com', 'subject' => 'Hi', 'html' => '<p>Hi</p>'];
    }

    public function test_send_adds_an_idempotency_key_and_reuses_it_on_retry(): void
    {
        $history = [];
        $client = $this->client([$this->json(503), $this->sent()], $history);

        $response = $client->emails()->send($this->email());

        $this->assertCount(2, $history);
        $first = $history[0]['request']->getHeaderLine('Idempotency-Key');
        $this->assertMatchesRegularExpression('/^[0-9a-f-]{36}$/', $first);
        $this->assertSame($first, $history[1]['request']->getHeaderLine('Idempotency-Key'));
        $this->assertSame('msg_1', $response->data()['id']);
    }

    public function test_caller_supplied_idempotency_key_is_sent(): void
    {
        $history = [];
        $client = $this->client([$this->sent()], $history);

        $client->emails()->send($this->email(), ['idempotency_key' => 'order-42']);

        $this->assertSame('order-42', $history[0]['request']->getHeaderLine('Idempotency-Key'));
    }

    public function test_rate_limited_requests_are_retried(): void
    {
        $history = [];
        $client = $this->client([$this->json(429, ['message' => 'slow down']), $this->sent()], $history);

        $client->emails()->send($this->email());

        $this->assertCount(2, $history);
    }

    public function test_gives_up_after_max_retries_with_rate_limit_exception(): void
    {
        $history = [];
        $limited = fn () => $this->json(429, ['message' => 'slow down'], ['X-RateLimit-Limit' => '10', 'X-RateLimit-Remaining' => '0']);
        $client = $this->client([$limited(), $limited(), $limited()], $history, maxRetries: 2);

        try {
            $client->emails()->send($this->email());
            $this->fail('Expected RateLimitException');
        } catch (RateLimitException $e) {
            $this->assertCount(3, $history);
            $this->assertSame(0, $e->rateLimit()?->remaining);
            $this->assertTrue($e->isRetryable());
        }
    }

    public function test_long_retry_after_is_not_waited_for(): void
    {
        $history = [];
        $client = $this->client([$this->json(429, [], ['Retry-After' => '120'])], $history, maxRetryDelay: 5);

        try {
            $client->domains()->list();
            $this->fail('Expected RateLimitException');
        } catch (RateLimitException $e) {
            $this->assertCount(1, $history);
            $this->assertSame(120, $e->getRetryAfter());
        }
    }

    public function test_server_errors_on_non_idempotent_posts_are_not_retried(): void
    {
        $history = [];
        $client = $this->client([$this->json(503, ['message' => 'down'])], $history);

        $this->expectException(\MailerMine\Exceptions\ApiException::class);

        try {
            $client->contacts()->create(['email' => 'a@example.com']);
        } finally {
            $this->assertCount(1, $history);
        }
    }

    public function test_connection_failures_on_get_are_retried(): void
    {
        $history = [];
        $client = $this->client([
            new ConnectException('timeout', new Request('GET', '/')),
            $this->json(200, ['success' => true, 'data' => []]),
        ], $history);

        $client->domains()->list();

        $this->assertCount(2, $history);
    }

    public function test_retries_can_be_disabled(): void
    {
        $history = [];
        $client = $this->client([$this->json(429)], $history, maxRetries: 0);

        $this->expectException(RateLimitException::class);

        try {
            $client->domains()->list();
        } finally {
            $this->assertCount(1, $history);
        }
    }

    public function test_responses_expose_rate_limit_and_replay_state(): void
    {
        $client = $this->client([$this->json(202, ['success' => true, 'data' => ['id' => 'msg_1']], [
            'X-RateLimit-Limit' => '600',
            'X-RateLimit-Remaining' => '12',
            'X-RateLimit-Reset' => (string) (time() + 30),
            'Idempotent-Replayed' => 'true',
        ])]);

        $response = $client->emails()->send($this->email(), ['idempotency_key' => 'k']);

        $this->assertSame(600, $response->rateLimit()?->limit);
        $this->assertSame(12, $response->rateLimit()?->remaining);
        $this->assertGreaterThan(0, $response->rateLimit()?->secondsUntilReset());
        $this->assertTrue($response->wasIdempotentReplay());
    }

    public function test_missing_scope_403_raises_missing_scope_exception(): void
    {
        $client = $this->client([$this->json(403, [
            'success' => false,
            'message' => 'This API key is missing the required scope: domains.read.',
            'errors' => ['scope' => ['domains.read']],
        ])]);

        try {
            $client->domains()->list();
            $this->fail('Expected MissingScopeException');
        } catch (MissingScopeException $e) {
            $this->assertSame(['domains.read'], $e->getMissingScopes());
            $this->assertStringNotContainsString('upgrade', strtolower($e->getMessage()));
        }
    }

    public function test_other_403s_are_still_plan_exceptions(): void
    {
        $client = $this->client([$this->json(403, ['success' => false, 'message' => 'Webhooks are not included in Free.'])]);

        $this->expectException(PlanException::class);

        $client->webhooks()->list();
    }

    public function test_new_scopes_are_accepted_when_creating_keys(): void
    {
        $history = [];
        $client = $this->client([$this->json(201, ['success' => true, 'data' => ['uuid' => 'k1']])], $history);

        $client->apiKeys()->create('proj_1', ['name' => 'Hooks', 'scopes' => [Scope::WEBHOOKS_WRITE, Scope::EVENTS_READ]]);

        $body = json_decode((string) $history[0]['request']->getBody(), true);
        $this->assertSame(['webhooks.write', 'events.read'], $body['scopes']);
        $this->assertContains('suppressions.write', Scope::all());
    }
}
