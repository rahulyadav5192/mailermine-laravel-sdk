<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use DateTimeImmutable;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as HttpResponse;
use MailerMine\Client;
use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\AuthenticationException;
use MailerMine\Exceptions\NotFoundException;
use MailerMine\Exceptions\RateLimitException;
use MailerMine\Exceptions\ValidationException;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use MailerMine\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Http\Message\RequestInterface;

final class EmailsTest extends TestCase
{
    public function test_send_maps_simple_arrays_to_the_generated_request(): void
    {
        $history = [];
        $client = $this->client([
            $this->jsonResponse(202, [
                'success' => true,
                'message' => 'Message queued successfully.',
                'data' => [
                    'uuid' => 'message-uuid',
                    'status' => 'queued',
                    'from_email' => 'hello@mailermine.com',
                    'to_email' => 'john@example.com',
                    'to_emails' => ['john@example.com'],
                    'cc' => ['copy@example.com'],
                    'bcc' => ['audit@example.com'],
                    'subject' => 'Hello',
                    'metadata' => ['customer_id' => '123'],
                    'tags' => ['welcome'],
                    'attachments' => [],
                ],
            ]),
        ], $history);

        $response = $client->emails()->send([
            'from' => 'hello@mailermine.com',
            'to' => 'john@example.com',
            'cc' => 'copy@example.com',
            'bcc' => 'audit@example.com',
            'reply_to' => 'support@mailermine.com',
            'subject' => 'Hello',
            'html' => '<h1>Hello</h1>',
            'tags' => ['welcome'],
            'metadata' => ['customer_id' => '123'],
            'attachments' => [[
                'filename' => 'hello.txt',
                'content' => base64_encode('Hello'),
                'content_type' => 'text/plain',
            ]],
        ]);

        self::assertInstanceOf(Response::class, $response);
        self::assertSame('message-uuid', $response->data()['uuid']);
        self::assertIsArray($response->data());

        $request = $this->recordedRequest($history);
        $payload = json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);

        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/emails', $request->getUri()->getPath());
        self::assertSame('Bearer test-api-key', $request->getHeaderLine('Authorization'));
        self::assertSame(['john@example.com'], $payload['to']);
        self::assertSame(['copy@example.com'], $payload['cc']);
        self::assertSame(['audit@example.com'], $payload['bcc']);
        self::assertSame('hello.txt', $payload['attachments'][0]['filename']);
        self::assertSame('text/plain', $payload['attachments'][0]['content_type']);
    }

    public function test_list_maps_filters_responses_and_pagination(): void
    {
        $history = [];
        $client = $this->client([
            $this->jsonResponse(200, [
                'success' => true,
                'message' => 'Messages retrieved successfully.',
                'data' => [[
                    'id' => 'message-uuid',
                    'from_email' => 'hello@mailermine.com',
                    'to_email' => 'john@example.com',
                    'subject' => 'Invoice',
                    'status' => 'sent',
                    'provider' => 'aws',
                    'metadata' => [],
                    'tags' => [],
                    'timeline' => [],
                ]],
                'meta' => [
                    'current_page' => 2,
                    'per_page' => 10,
                    'total' => 31,
                    'last_page' => 4,
                ],
            ]),
        ], $history);

        $emails = $client->emails()->list([
            'search' => 'invoice',
            'status' => 'sent',
            'provider' => 'aws',
            'from' => new DateTimeImmutable('2026-07-01T00:00:00+00:00'),
            'to' => '2026-07-31T23:59:59+00:00',
            'page' => 2,
            'per_page' => 10,
        ]);

        self::assertInstanceOf(Collection::class, $emails);
        self::assertSame('message-uuid', $emails->first()['id']);
        self::assertIsArray($emails->first());
        self::assertSame(2, $emails->pagination()?->currentPage);
        self::assertSame(31, $emails->pagination()?->total);
        self::assertTrue($emails->pagination()?->hasMorePages());

        parse_str($this->recordedRequest($history)->getUri()->getQuery(), $query);

        self::assertSame('invoice', $query['search']);
        self::assertSame('sent', $query['status']);
        self::assertSame('aws', $query['provider']);
        self::assertSame('2026-07-01T00:00:00+00:00', $query['from']);
        self::assertSame('2', $query['page']);
        self::assertSame('10', $query['per_page']);
    }

    public function test_get_returns_clean_message_data(): void
    {
        $history = [];
        $client = $this->client([
            $this->jsonResponse(200, [
                'success' => true,
                'message' => 'Message retrieved successfully.',
                'data' => [
                    'id' => 'message-uuid',
                    'from_email' => 'hello@mailermine.com',
                    'to_email' => 'john@example.com',
                    'subject' => 'Hello',
                    'status' => 'delivered',
                    'provider' => 'aws',
                    'metadata' => [],
                    'tags' => [],
                    'timeline' => [],
                ],
            ]),
        ], $history);

        $response = $client->emails()->get('message-uuid');

        self::assertSame('message-uuid', $response->data()['id']);
        self::assertSame('/api/v1/delivery-logs/message-uuid', $this->recordedRequest($history)->getUri()->getPath());
    }

    public function test_events_returns_a_clean_collection(): void
    {
        $history = [];
        $client = $this->client([
            $this->jsonResponse(200, [
                'data' => [[
                    'id' => 'event-uuid',
                    'event_type' => 'delivered',
                    'event_label' => 'Delivered',
                    'source' => 'transactional',
                    'payload' => [],
                    'message_id' => 'message-uuid',
                    'recipient' => 'john@example.com',
                    'metadata' => [],
                    'tags' => [],
                ]],
            ]),
        ], $history);

        $events = $client->emails()->events('message-uuid');

        self::assertSame('delivered', $events->first()['event_type']);
        self::assertIsArray($events->first());
        self::assertSame('/api/v1/messages/message-uuid/events', $this->recordedRequest($history)->getUri()->getPath());
    }

    /**
     * @return iterable<string, array{int, class-string<ApiException>}>
     */
    public static function errorStatuses(): iterable
    {
        yield 'unauthorized' => [401, AuthenticationException::class];
        yield 'forbidden' => [403, AuthenticationException::class];
        yield 'not found' => [404, NotFoundException::class];
        yield 'validation failed' => [422, ValidationException::class];
        yield 'rate limited' => [429, RateLimitException::class];
        yield 'server error' => [500, ApiException::class];
    }

    /**
     * @param  class-string<ApiException>  $expectedException
     */
    #[DataProvider('errorStatuses')]
    public function test_error_responses_are_mapped_to_sdk_exceptions(
        int $status,
        string $expectedException,
    ): void {
        $body = [
            'success' => false,
            'message' => 'Request failed.',
        ];

        if ($status === 422) {
            $body['errors'] = ['to' => ['The to field is required.']];
        }

        $client = $this->client([
            $this->jsonResponse($status, $body, ['Retry-After' => '45']),
        ]);

        try {
            $client->emails()->send([
                'from' => 'hello@mailermine.com',
                'to' => 'john@example.com',
                'subject' => 'Hello',
                'html' => '<h1>Hello</h1>',
            ]);
            self::fail('Expected an SDK exception.');
        } catch (ApiException $exception) {
            self::assertInstanceOf($expectedException, $exception);
            self::assertSame($status, $exception->getStatusCode());
            self::assertSame('Request failed.', $exception->getMessage());

            if ($exception instanceof ValidationException) {
                self::assertSame(['to' => ['The to field is required.']], $exception->getErrors());
            }

            if ($exception instanceof RateLimitException) {
                self::assertSame(45, $exception->getRetryAfter());
            }
        }
    }

    /**
     * @param  list<HttpResponse>  $responses
     * @param  array<int, array<string, mixed>>  $history
     */
    private function client(array $responses, array &$history = []): Client
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($history));

        return new Client(
            'test-api-key',
            'https://api.example.test/api/v1',
            new GuzzleClient([
                'handler' => $stack,
                'http_errors' => false,
            ]),
        );
    }

    /**
     * @param  array<string, mixed>  $body
     * @param  array<string, string>  $headers
     */
    private function jsonResponse(int $status, array $body, array $headers = []): HttpResponse
    {
        return new HttpResponse(
            $status,
            ['Content-Type' => 'application/json', ...$headers],
            json_encode($body, JSON_THROW_ON_ERROR),
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $history
     */
    private function recordedRequest(array $history): RequestInterface
    {
        self::assertCount(1, $history);
        self::assertInstanceOf(RequestInterface::class, $history[0]['request']);

        return $history[0]['request'];
    }
}
