<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class ListsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_list_crud_and_membership_operations(): void
    {
        $history = [];
        $list = ['id' => 'list-1', 'name' => 'Newsletter'];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource($list)),
            $this->mockJsonResponse(200, $this->paginated([$list])),
            $this->mockJsonResponse(200, $this->resource($list)),
            $this->mockJsonResponse(200, $this->resource([...$list, 'name' => 'Product Updates'])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Added.', 'data' => ['added' => 2]]),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Removed.', 'data' => ['removed' => 1]]),
        ], $history);

        $created = $client->lists()->create(['name' => 'Newsletter']);
        $lists = $client->lists()->list(['page' => 1]);
        $retrieved = $client->lists()->get('list-1');
        $updated = $client->lists()->update('list-1', ['name' => 'Product Updates']);
        $deleted = $client->lists()->delete('list-1');
        $added = $client->lists()->addContact('list-1', ['contact-1', 'contact-2']);
        $removed = $client->lists()->removeContact('list-1', 'contact-1');

        self::assertSame('list-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $lists);
        self::assertSame(1, $lists->pagination()?->total);
        self::assertSame('list-1', $retrieved->data()['id']);
        self::assertSame('Product Updates', $updated->data()['name']);
        self::assertTrue($deleted->success());
        self::assertSame(2, $added->data()['added']);
        self::assertSame(1, $removed->data()['removed']);

        self::assertSame(['contact-1', 'contact-2'], $this->body($this->historyRequest($history, 5))['ids']);
        self::assertSame('/api/v1/lists/list-1/contacts/bulk-remove', $this->historyRequest($history, 6)->getUri()->getPath());
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
