<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;

final class AudiencesTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_audience_catalog_and_delegation(): void
    {
        $history = [];
        $audience = [
            'id' => 'list-1',
            'name' => 'VIP',
            'source' => 'list',
            'type' => 'list',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource(['id' => 'list-1', 'name' => 'VIP'])),
            $this->mockJsonResponse(200, $this->paginated([$audience])),
            $this->mockJsonResponse(200, $this->resource($audience)),
            $this->mockJsonResponse(200, $this->resource(['id' => 'list-1', 'name' => 'VIP Customers'])),
            $this->mockJsonResponse(200, $this->paginated([[
                'id' => 'contact-1',
                'email' => 'john@example.com',
            ]])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
        ], $history);

        $created = $client->audiences()->create([
            'source' => 'list',
            'name' => 'VIP',
        ]);
        $audiences = $client->audiences()->list();
        $retrieved = $client->audiences()->get('list', 'list-1');
        $updated = $client->audiences()->update('list', 'list-1', [
            'name' => 'VIP Customers',
        ]);
        $contacts = $client->audiences()->contacts('list', 'list-1');
        $deleted = $client->audiences()->delete('list', 'list-1');

        self::assertSame('list-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $audiences);
        self::assertSame('VIP', $retrieved->data()['name']);
        self::assertSame('VIP Customers', $updated->data()['name']);
        self::assertSame('john@example.com', $contacts->first()['email']);
        self::assertTrue($deleted->success());

        self::assertSame('POST', $this->historyRequest($history, 0)->getMethod());
        self::assertSame('/api/v1/lists', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame('/api/v1/audiences', $this->historyRequest($history, 1)->getUri()->getPath());
        self::assertSame('/api/v1/audiences/list/list-1', $this->historyRequest($history, 2)->getUri()->getPath());
        parse_str($this->historyRequest($history, 4)->getUri()->getQuery(), $query);
        self::assertSame('list-1', $query['list']);
        self::assertSame('DELETE', $this->historyRequest($history, 5)->getMethod());
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function resource(array $data): array
    {
        return ['success' => true, 'message' => 'OK', 'data' => $data];
    }

    /**
     * @param  list<array<string, mixed>>  $data
     * @return array<string, mixed>
     */
    private function paginated(array $data): array
    {
        return [
            'success' => true,
            'message' => 'OK',
            'data' => $data,
            'meta' => [
                'current_page' => 1,
                'per_page' => 25,
                'total' => count($data),
                'last_page' => 1,
            ],
        ];
    }
}
