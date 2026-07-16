<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\RateLimitException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class TemplatesTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_template_operations_map_requests_responses_and_pagination(): void
    {
        $history = [];
        $template = [
            'id' => 'template-1',
            'name' => 'Welcome Email',
            'subject' => 'Welcome {{first_name}}',
            'status' => 'published',
        ];
        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resourceResponse($template)),
            $this->mockJsonResponse(200, $this->listResponse([$template])),
            $this->mockJsonResponse(200, $this->resourceResponse($template)),
            $this->mockJsonResponse(200, $this->resourceResponse([...$template, 'subject' => 'Hello {{first_name}}'])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Template deleted.', 'data' => []]),
            $this->mockJsonResponse(201, $this->resourceResponse([...$template, 'id' => 'template-2'])),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Rendered.',
                'data' => [
                    'subject' => 'Welcome John',
                    'html' => '<h1>Welcome John</h1>',
                    'text' => 'Welcome John',
                ],
            ]),
            $this->mockJsonResponse(202, [
                'success' => true,
                'message' => 'Test queued.',
                'data' => ['to' => 'john@example.com', 'template_id' => 'template-1'],
            ]),
        ], $history);

        $created = $client->templates()->create([
            'name' => 'Welcome Email',
            'subject' => 'Welcome {{first_name}}',
            'html' => '<h1>Welcome {{first_name}}</h1>',
        ]);
        $templates = $client->templates()->list([
            'status' => 'published',
            'editor_type' => 'code',
        ]);
        $retrieved = $client->templates()->get('template-1');
        $updated = $client->templates()->update('template-1', [
            'subject' => 'Hello {{first_name}}',
        ]);
        $deleted = $client->templates()->delete('template-1');
        $duplicated = $client->templates()->duplicate('template-1', [
            'name' => 'Welcome Copy',
        ]);
        $preview = $client->templates()->preview('template-1', ['first_name' => 'John']);
        $test = $client->templates()->test('template-1', [
            'email' => 'john@example.com',
            'variables' => ['first_name' => 'John'],
        ]);

        self::assertSame('template-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $templates);
        self::assertSame('template-1', $templates->first()['id']);
        self::assertSame(1, $templates->pagination()?->lastPage);
        self::assertSame('template-1', $retrieved->data()['id']);
        self::assertSame('Hello {{first_name}}', $updated->data()['subject']);
        self::assertTrue($deleted->success());
        self::assertSame('template-2', $duplicated->data()['id']);
        self::assertSame('<h1>Welcome John</h1>', $preview->data()['html']);
        self::assertSame('john@example.com', $test->data()['to']);

        self::assertSame('POST', $this->historyRequest($history, 0)->getMethod());
        self::assertSame('Welcome Email', $this->body($this->historyRequest($history, 0))['name']);
        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertSame('published', $query['status']);
        self::assertSame('code', $query['editor_type']);
        self::assertSame('/api/v1/templates/template-1', $this->historyRequest($history, 2)->getUri()->getPath());
        self::assertSame('PATCH', $this->historyRequest($history, 3)->getMethod());
        self::assertSame('DELETE', $this->historyRequest($history, 4)->getMethod());
        self::assertSame('/api/v1/templates/template-1/duplicate', $this->historyRequest($history, 5)->getUri()->getPath());
        self::assertSame('Welcome Copy', $this->body($this->historyRequest($history, 5))['name']);
        self::assertSame('/api/v1/templates/template-1/preview', $this->historyRequest($history, 6)->getUri()->getPath());
        self::assertSame(['first_name' => 'John'], $this->body($this->historyRequest($history, 6))['variables']);
        self::assertSame('/api/v1/templates/template-1/test', $this->historyRequest($history, 7)->getUri()->getPath());
        self::assertSame('john@example.com', $this->body($this->historyRequest($history, 7))['to']);
    }

    public function test_template_errors_are_mapped_to_sdk_exceptions(): void
    {
        $client = $this->mockClient([
            $this->mockJsonResponse(429, [
                'success' => false,
                'message' => 'Too many template tests.',
            ], ['Retry-After' => '30']),
        ]);

        try {
            $client->templates()->test('template-1', ['to' => 'john@example.com']);
            self::fail('Expected a RateLimitException.');
        } catch (RateLimitException $exception) {
            self::assertSame(429, $exception->getStatusCode());
            self::assertSame(30, $exception->getRetryAfter());
            self::assertSame('Too many template tests.', $exception->getMessage());
        }
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
