<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\ValidationException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class ApiKeysTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_api_key_operations_map_requests_responses_and_pagination(): void
    {
        $history = [];
        $key = ['id' => 'key-1', 'name' => 'Production', 'status' => 'active'];
        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resourceResponse([...$key, 'secret' => 'mm_live_create'])),
            $this->mockJsonResponse(200, $this->listResponse([$key])),
            $this->mockJsonResponse(200, $this->resourceResponse($key)),
            $this->mockJsonResponse(200, $this->resourceResponse([...$key, 'name' => 'Sender'])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'API key deleted.', 'data' => []]),
            $this->mockJsonResponse(200, $this->resourceResponse([...$key, 'secret' => 'mm_live_rotated'])),
        ], $history);

        $created = $client->apiKeys()->create('project-1', [
            'name' => 'Production',
            'scopes' => ['emails.send'],
        ]);
        $keys = $client->apiKeys()->list('project-1', ['status' => 'active']);
        $retrieved = $client->apiKeys()->get('project-1', 'key-1');
        $updated = $client->apiKeys()->update('project-1', 'key-1', ['name' => 'Sender']);
        $deleted = $client->apiKeys()->delete('project-1', 'key-1');
        $rotated = $client->apiKeys()->rotate('project-1', 'key-1');

        self::assertSame('mm_live_create', $created->data()['secret']);
        self::assertInstanceOf(Collection::class, $keys);
        self::assertSame('key-1', $keys->first()['id']);
        self::assertSame(1, $keys->pagination()?->currentPage);
        self::assertSame('key-1', $retrieved->data()['id']);
        self::assertSame('Sender', $updated->data()['name']);
        self::assertTrue($deleted->success());
        self::assertSame('mm_live_rotated', $rotated->data()['secret']);

        $create = $this->historyRequest($history, 0);
        self::assertSame('POST', $create->getMethod());
        self::assertSame('/api/v1/projects/project-1/api-keys', $create->getUri()->getPath());
        self::assertSame(['emails.send'], $this->body($create)['scopes']);

        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertSame('active', $query['status']);
        self::assertSame('/api/v1/projects/project-1/api-keys/key-1', $this->historyRequest($history, 2)->getUri()->getPath());
        self::assertSame('PATCH', $this->historyRequest($history, 3)->getMethod());
        self::assertSame('DELETE', $this->historyRequest($history, 4)->getMethod());
        self::assertSame(
            '/api/v1/projects/project-1/api-keys/key-1/rotate',
            $this->historyRequest($history, 5)->getUri()->getPath(),
        );
    }

    public function test_reveal_maps_the_documented_validation_failure(): void
    {
        $history = [];
        $client = $this->mockClient([
            $this->mockJsonResponse(422, [
                'success' => false,
                'message' => 'API key secrets cannot be revealed.',
                'errors' => ['api_key' => ['Rotate the key to issue a new secret.']],
            ]),
        ], $history);

        try {
            $client->apiKeys()->reveal('project-1', 'key-1');
            self::fail('Expected a ValidationException.');
        } catch (ValidationException $exception) {
            self::assertSame('API key secrets cannot be revealed.', $exception->getMessage());
            self::assertSame(
                ['api_key' => ['Rotate the key to issue a new secret.']],
                $exception->getErrors(),
            );
        }

        self::assertSame(
            '/api/v1/projects/project-1/api-keys/key-1/reveal',
            $this->historyRequest($history)->getUri()->getPath(),
        );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function resourceResponse(array $data): array
    {
        return ['success' => true, 'message' => 'OK', 'data' => $data];
    }

    /**
     * @param  list<array<string, mixed>>  $data
     * @return array<string, mixed>
     */
    private function listResponse(array $data): array
    {
        return [
            'success' => true,
            'message' => 'OK',
            'data' => $data,
            'meta' => [
                'current_page' => 1,
                'per_page' => 25,
                'total' => 1,
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
