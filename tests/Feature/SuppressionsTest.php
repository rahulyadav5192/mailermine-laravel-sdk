<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\NotFoundException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class SuppressionsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_suppression_list_add_check_remove_and_restore(): void
    {
        $history = [];
        $suppression = [
            'id' => 'suppression-1',
            'email' => 'john@example.com',
            'reason' => 'manual',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource($suppression)),
            $this->mockJsonResponse(200, $this->list([$suppression])),
            $this->mockJsonResponse(200, $this->list([$suppression])),
            $this->mockJsonResponse(200, $this->list([$suppression])),
            $this->mockJsonResponse(200, $this->list([])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
            $this->mockJsonResponse(200, $this->resource($suppression)),
            $this->mockJsonResponse(200, $this->list([])),
        ], $history);

        $created = $client->suppressions()->add([
            'email' => 'john@example.com',
            'reason' => 'manual',
        ]);
        $listed = $client->suppressions()->list(['reason' => 'manual']);
        $retrieved = $client->suppressions()->get('suppression-1');
        $check = $client->suppressions()->check('john@example.com');
        $missing = $client->suppressions()->check('missing@example.com');
        $removed = $client->suppressions()->remove('suppression-1');
        $restored = $client->suppressions()->restore('suppression-1');

        self::assertSame('suppression-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $listed);
        self::assertSame('john@example.com', $listed->first()['email']);
        self::assertSame('suppression-1', $retrieved->data()['id']);
        self::assertTrue($check->data()['suppressed']);
        self::assertFalse($missing->data()['suppressed']);
        self::assertTrue($removed->success());
        self::assertSame('suppression-1', $restored->data()['id']);

        self::assertSame('/api/v1/suppressions', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame([
            'email' => 'john@example.com',
            'reason' => 'manual',
        ], $this->body($this->historyRequest($history, 0)));
        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertSame('manual', $query['reason']);
        self::assertSame('/api/v1/suppressions/suppression-1', $this->historyRequest($history, 5)->getUri()->getPath());
        self::assertSame('/api/v1/suppressions/suppression-1/restore', $this->historyRequest($history, 6)->getUri()->getPath());
    }

    public function test_get_throws_when_suppression_missing(): void
    {
        $history = [];
        $client = $this->mockClient([
            $this->mockJsonResponse(200, $this->list([])),
        ], $history);

        $this->expectException(NotFoundException::class);
        $client->suppressions()->get('missing');
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

    /**
     * @return array<string, mixed>
     */
    private function body(RequestInterface $request): array
    {
        $raw = (string) $request->getBody();

        if ($raw === '') {
            return [];
        }

        /** @var array<string, mixed> $decoded */
        $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        return $decoded;
    }
}
