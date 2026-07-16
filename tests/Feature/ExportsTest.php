<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\NotFoundException;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class ExportsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_export_create_status_and_download(): void
    {
        $history = [];
        $export = [
            'id' => 'export-1',
            'status' => 'queued',
            'contact_count' => 0,
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(202, $this->resource($export)),
            $this->mockJsonResponse(200, $this->resource([
                ...$export,
                'status' => 'completed',
                'contact_count' => 2,
                'download_url' => 'https://api.example.test/api/v1/contacts/exports/export-1/download',
            ])),
            new \GuzzleHttp\Psr7\Response(
                200,
                ['Content-Type' => 'text/csv'],
                "email,first_name\njohn@example.com,John\n",
            ),
        ], $history);

        $created = $client->exports()->create([
            'status' => 'active',
            'subscribed' => true,
        ]);
        $status = $client->exports()->status('export-1');
        $download = $client->exports()->download('export-1');

        self::assertSame('export-1', $created->data()['id']);
        self::assertSame('completed', $status->data()['status']);
        self::assertStringContainsString('john@example.com', $download->data());

        self::assertSame('/api/v1/contacts/export', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertTrue($this->body($this->historyRequest($history, 0))['subscribed']);
        self::assertSame('/api/v1/contacts/exports/export-1', $this->historyRequest($history, 1)->getUri()->getPath());
        self::assertSame(
            '/api/v1/contacts/exports/export-1/download',
            $this->historyRequest($history, 2)->getUri()->getPath(),
        );
    }

    public function test_export_errors_are_mapped(): void
    {
        $client = $this->mockClient([
            $this->mockJsonResponse(404, [
                'success' => false,
                'message' => 'Export not found.',
            ]),
        ]);

        $this->expectException(NotFoundException::class);
        $client->exports()->status('missing');
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
     * @return array<string, mixed>
     */
    private function body(RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
