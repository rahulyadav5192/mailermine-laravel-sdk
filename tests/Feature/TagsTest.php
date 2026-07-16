<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class TagsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_tag_create_list_assign_and_remove(): void
    {
        $history = [];
        $tag = ['id' => 'tag-1', 'name' => 'vip'];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource($tag)),
            $this->mockJsonResponse(200, $this->paginated([$tag])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Assigned.', 'data' => ['assigned' => 1]]),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Removed.', 'data' => ['removed' => 1]]),
        ], $history);

        $created = $client->tags()->create(['name' => 'vip']);
        $tags = $client->tags()->list(['search' => 'vip']);
        $assigned = $client->tags()->assign([
            'contact_ids' => 'contact-1',
            'tag_ids' => ['tag-1'],
        ]);
        $removed = $client->tags()->remove([
            'contact_ids' => ['contact-1'],
            'tag_ids' => 'tag-1',
        ]);

        self::assertSame('tag-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $tags);
        self::assertSame(1, $tags->pagination()?->total);
        self::assertSame(1, $assigned->data()['assigned']);
        self::assertSame(1, $removed->data()['removed']);

        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertSame('vip', $query['search']);
        self::assertSame(['contact-1'], $this->body($this->historyRequest($history, 2))['contact_ids']);
        self::assertSame(['tag-1'], $this->body($this->historyRequest($history, 2))['tag_ids']);
        self::assertSame('/api/v1/tags/bulk-remove', $this->historyRequest($history, 3)->getUri()->getPath());
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
