<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\NotFoundException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;

final class EventsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_event_list_get_timeline_and_message(): void
    {
        $history = [];
        $event = [
            'id' => 'event-1',
            'event_type' => 'email.opened',
            'message_id' => 'message-1',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(200, $this->list([$event])),
            $this->mockJsonResponse(200, $this->resource($event)),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'OK',
                'data' => [
                    $event,
                    ['id' => 'event-2', 'event_type' => 'email.clicked'],
                ],
            ]),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'OK',
                'data' => [$event],
            ]),
            $this->mockJsonResponse(200, $this->resource([
                'id' => 'message-1',
                'status' => 'delivered',
                'to' => 'john@example.com',
            ])),
        ], $history);

        $listed = $client->events()->list([
            'event_type' => 'email.opened',
            'from' => '2026-01-01',
            'message' => 'message-1',
        ]);
        $retrieved = $client->events()->get('event-1');
        $timeline = $client->events()->timeline('message-1');
        $historyEvents = $client->events()->history('message-1');
        $message = $client->events()->message('message-1');

        self::assertInstanceOf(Collection::class, $listed);
        self::assertSame('event-1', $listed->first()['id']);
        self::assertSame(1, $listed->pagination()?->currentPage);
        self::assertSame('email.opened', $retrieved->data()['event_type']);
        self::assertSame(2, $timeline->count());
        self::assertSame(1, $historyEvents->count());
        self::assertSame('delivered', $message->data()['status']);

        self::assertSame('/api/v1/events', $this->historyRequest($history, 0)->getUri()->getPath());
        parse_str($this->historyRequest($history, 0)->getUri()->getQuery(), $query);
        self::assertSame('email.opened', $query['event_type']);
        self::assertSame('message-1', $query['message']);
        self::assertSame('/api/v1/events/event-1', $this->historyRequest($history, 1)->getUri()->getPath());
        self::assertSame('/api/v1/messages/message-1/events', $this->historyRequest($history, 2)->getUri()->getPath());
        self::assertSame('/api/v1/delivery-logs/message-1', $this->historyRequest($history, 4)->getUri()->getPath());
    }

    public function test_not_found_is_mapped(): void
    {
        $history = [];
        $client = $this->mockClient([
            $this->mockJsonResponse(404, [
                'success' => false,
                'message' => 'Event not found.',
            ]),
        ], $history);

        $this->expectException(NotFoundException::class);
        $client->events()->get('missing');
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
