<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\NotFoundException;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use MailerMine\Tests\TestCase;

final class ProjectsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_project_crud_maps_requests_and_clean_responses(): void
    {
        $history = [];
        $project = ['id' => 'project-1', 'name' => 'Production Mail', 'status' => 'active'];
        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resourceResponse($project)),
            $this->mockJsonResponse(200, $this->listResponse([$project])),
            $this->mockJsonResponse(200, $this->resourceResponse($project)),
            $this->mockJsonResponse(200, $this->resourceResponse([...$project, 'name' => 'Production Email'])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Project deleted.', 'data' => []]),
        ], $history);

        $created = $client->projects()->create([
            'name' => 'Production Mail',
            'environment' => 'production',
        ]);
        $projects = $client->projects()->list([
            'status' => 'active',
            'page' => 2,
            'per_page' => 10,
        ]);
        $retrieved = $client->projects()->get('project-1');
        $updated = $client->projects()->update('project-1', ['name' => 'Production Email']);
        $deleted = $client->projects()->delete('project-1');

        self::assertInstanceOf(Response::class, $created);
        self::assertSame('project-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $projects);
        self::assertSame('project-1', $projects->first()['id']);
        self::assertSame(2, $projects->pagination()?->currentPage);
        self::assertSame(12, $projects->pagination()?->total);
        self::assertSame('project-1', $retrieved->data()['id']);
        self::assertSame('Production Email', $updated->data()['name']);
        self::assertTrue($deleted->success());

        $createRequest = $this->historyRequest($history, 0);
        self::assertSame('POST', $createRequest->getMethod());
        self::assertSame('/api/v1/projects', $createRequest->getUri()->getPath());
        self::assertSame('Production Mail', $this->body($createRequest)['name']);

        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertSame('active', $query['status']);
        self::assertSame('2', $query['page']);
        self::assertSame('10', $query['per_page']);

        self::assertSame('/api/v1/projects/project-1', $this->historyRequest($history, 2)->getUri()->getPath());
        self::assertSame('PATCH', $this->historyRequest($history, 3)->getMethod());
        self::assertSame('Production Email', $this->body($this->historyRequest($history, 3))['name']);
        self::assertSame('DELETE', $this->historyRequest($history, 4)->getMethod());
    }

    public function test_project_errors_are_mapped_to_sdk_exceptions(): void
    {
        $client = $this->mockClient([
            $this->mockJsonResponse(404, [
                'success' => false,
                'message' => 'Project not found.',
            ]),
        ]);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Project not found.');

        $client->projects()->get('missing');
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
                'current_page' => 2,
                'per_page' => 10,
                'total' => 12,
                'last_page' => 2,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function body(\Psr\Http\Message\RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
