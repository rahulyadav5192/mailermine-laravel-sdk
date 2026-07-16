<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class SegmentsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_segment_crud_and_preview(): void
    {
        $history = [];
        $rules = [
            'logic' => 'and',
            'rules' => [
                ['field' => 'subscribed', 'operator' => 'equals', 'value' => true],
            ],
        ];
        $segment = ['id' => 'segment-1', 'name' => 'Active subscribers', 'rules' => $rules];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource($segment)),
            $this->mockJsonResponse(200, $this->paginated([$segment])),
            $this->mockJsonResponse(200, $this->resource($segment)),
            $this->mockJsonResponse(200, $this->resource([...$segment, 'name' => 'Engaged'])),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Preview ready.',
                'data' => [
                    'count' => 12,
                    'contacts' => [['id' => 'contact-1', 'email' => 'john@example.com']],
                ],
            ]),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Preview ready.',
                'data' => ['count' => 3, 'contacts' => []],
            ]),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
        ], $history);

        $created = $client->segments()->create([
            'name' => 'Active subscribers',
            'rules' => $rules,
        ]);
        $segments = $client->segments()->list();
        $retrieved = $client->segments()->get('segment-1');
        $updated = $client->segments()->update('segment-1', ['name' => 'Engaged']);
        $savedPreview = $client->segments()->preview('segment-1');
        $rulesPreview = $client->segments()->preview(null, $rules);
        $deleted = $client->segments()->delete('segment-1');

        self::assertSame('segment-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $segments);
        self::assertSame(1, $segments->pagination()?->total);
        self::assertSame('segment-1', $retrieved->data()['id']);
        self::assertSame('Engaged', $updated->data()['name']);
        self::assertSame(12, $savedPreview->data()['count']);
        self::assertSame(3, $rulesPreview->data()['count']);
        self::assertTrue($deleted->success());

        self::assertSame($rules, $this->body($this->historyRequest($history, 0))['rules']);
        self::assertSame('/api/v1/segments/segment-1/preview', $this->historyRequest($history, 4)->getUri()->getPath());
        self::assertSame('/api/v1/segments/preview', $this->historyRequest($history, 5)->getUri()->getPath());
        self::assertSame($rules, $this->body($this->historyRequest($history, 5))['rules']);
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

    /**
     * @return array<string, mixed>
     */
    private function body(RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
