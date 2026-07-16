<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;

final class MessagesTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_delivery_log_list_search_filter_and_pagination(): void
    {
        $history = [];
        $log = [
            'id' => 'message-1',
            'status' => 'delivered',
            'to' => 'john@example.com',
            'provider' => 'ses',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(200, $this->list([$log])),
            $this->mockJsonResponse(200, $this->resource($log)),
            $this->mockJsonResponse(200, $this->list([$log])),
            $this->mockJsonResponse(200, $this->list([$log])),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'OK',
                'data' => [
                    ['id' => 'event-1', 'event_type' => 'email.delivered'],
                ],
            ]),
        ], $history);

        $listed = $client->messages()->list([
            'status' => 'delivered',
            'from' => '2026-01-01',
            'page' => 2,
            'per_page' => 10,
        ]);
        $retrieved = $client->messages()->get('message-1');
        $searched = $client->messages()->search('john@example.com', ['status' => 'delivered']);
        $filtered = $client->messages()->filter(['provider' => 'ses']);
        $events = $client->messages()->timeline('message-1');

        self::assertInstanceOf(Collection::class, $listed);
        self::assertSame('message-1', $listed->first()['id']);
        self::assertSame(1, $listed->pagination()?->currentPage);
        self::assertSame('delivered', $retrieved->data()['status']);
        self::assertSame('john@example.com', $searched->first()['to']);
        self::assertSame('ses', $filtered->first()['provider']);
        self::assertSame('email.delivered', $events->first()['event_type']);

        parse_str($this->historyRequest($history, 0)->getUri()->getQuery(), $query);
        self::assertSame('delivered', $query['status']);
        self::assertSame('2', $query['page']);
        self::assertSame('10', $query['per_page']);
        self::assertSame('/api/v1/delivery-logs', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame('/api/v1/delivery-logs/message-1', $this->historyRequest($history, 1)->getUri()->getPath());
        parse_str($this->historyRequest($history, 2)->getUri()->getQuery(), $searchQuery);
        self::assertSame('john@example.com', $searchQuery['search']);
        parse_str($this->historyRequest($history, 3)->getUri()->getQuery(), $filterQuery);
        self::assertSame('ses', $filterQuery['provider']);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function resource(array $data): array
    {
        return [
            'success' => true,
            'message' => 'OK',
            'data' => $data,
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $data
     * @return array<string, mixed>
     */
    private function list(array $data): array
    {
        return [
            'success' => true,
            'message' => 'OK',
            'data' => $data,
            'meta' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 25,
                'total' => count($data),
            ],
        ];
    }
}
