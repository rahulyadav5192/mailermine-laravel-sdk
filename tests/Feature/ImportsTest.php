<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\ApiException;
use MailerMine\Tests\TestCase;

final class ImportsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_import_create_status_configure_and_start(): void
    {
        $history = [];
        $file = tempnam(sys_get_temp_dir(), 'mm-import-');
        self::assertNotFalse($file);
        file_put_contents($file, "email,first_name\njohn@example.com,John\n");

        try {
            $job = [
                'id' => 'import-1',
                'status' => 'uploaded',
                'filename' => basename($file),
            ];

            $client = $this->mockClient([
                $this->mockJsonResponse(201, $this->resource($job)),
                $this->mockJsonResponse(200, $this->resource([...$job, 'status' => 'configured'])),
                $this->mockJsonResponse(202, $this->resource([...$job, 'status' => 'queued'])),
                $this->mockJsonResponse(200, $this->resource([...$job, 'status' => 'processing'])),
            ], $history);

            $created = $client->imports()->create(['file' => $file]);
            $configured = $client->imports()->configure('import-1', [
                'field_mappings' => ['email' => 'email'],
                'duplicate_strategy' => 'update',
            ]);
            $started = $client->imports()->start('import-1');
            $status = $client->imports()->status('import-1');

            self::assertSame('import-1', $created->data()['id']);
            self::assertSame('configured', $configured->data()['status']);
            self::assertSame('queued', $started->data()['status']);
            self::assertSame('processing', $status->data()['status']);

            $upload = $this->historyRequest($history, 0);
            self::assertSame('POST', $upload->getMethod());
            self::assertSame('/api/v1/contacts/import', $upload->getUri()->getPath());
            self::assertStringContainsString('multipart/form-data', $upload->getHeaderLine('Content-Type'));
            self::assertStringContainsString('john@example.com', (string) $upload->getBody());
            self::assertSame('/api/v1/contacts/imports/import-1/config', $this->historyRequest($history, 1)->getUri()->getPath());
            self::assertSame('/api/v1/contacts/imports/import-1/start', $this->historyRequest($history, 2)->getUri()->getPath());
            self::assertSame('/api/v1/contacts/imports/import-1', $this->historyRequest($history, 3)->getUri()->getPath());
        } finally {
            @unlink($file);
        }
    }

    public function test_import_cancel_is_unsupported(): void
    {
        $client = $this->mockClient([]);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('does not support cancelling import');

        $client->imports()->cancel('import-1');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function resource(array $data): array
    {
        return ['success' => true, 'message' => 'OK', 'data' => $data];
    }
}
