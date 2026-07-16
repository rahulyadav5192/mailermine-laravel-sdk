<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as HttpResponse;
use MailerMine\Client;
use Psr\Http\Message\RequestInterface;

trait MocksMailerMineApi
{
    /**
     * @param  list<HttpResponse>  $responses
     * @param  array<int, array<string, mixed>>  $history
     */
    private function mockClient(array $responses, array &$history = []): Client
    {
        $stack = HandlerStack::create(new MockHandler($responses));
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
    private function mockJsonResponse(int $status, array $body, array $headers = []): HttpResponse
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
    private function historyRequest(array $history, int $index = 0): RequestInterface
    {
        self::assertArrayHasKey($index, $history);
        self::assertInstanceOf(RequestInterface::class, $history[$index]['request']);

        return $history[$index]['request'];
    }
}
