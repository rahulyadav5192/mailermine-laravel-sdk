<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\ApiException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class DomainsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_domain_operations_map_requests_responses_and_projections(): void
    {
        $history = [];
        $domain = [
            'id' => 'domain-1',
            'domain' => 'mail.example.com',
            'status' => 'pending',
            'verified' => false,
            'verification_status' => 'pending',
            'dns_status' => 'pending',
            'dkim_status' => 'verified',
            'spf_status' => 'pending',
            'tracking_status' => 'verified',
            'dns_records' => [[
                'record_type' => 'TXT',
                'record_name' => 'mail.example.com',
                'record_value' => 'mailermine-verification=value',
                'status' => 'pending',
            ]],
        ];
        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resourceResponse($domain)),
            $this->mockJsonResponse(200, $this->listResponse([$domain])),
            $this->mockJsonResponse(200, $this->resourceResponse($domain)),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Domain deleted.', 'data' => []]),
            $this->mockJsonResponse(200, $this->resourceResponse([...$domain, 'verified' => true])),
            $this->mockJsonResponse(200, $this->resourceResponse($domain)),
            $this->mockJsonResponse(200, $this->resourceResponse($domain)),
        ], $history);

        $created = $client->domains()->create(['domain' => 'mail.example.com']);
        $domains = $client->domains()->list(['status' => 'pending']);
        $retrieved = $client->domains()->get('domain-1');
        $deleted = $client->domains()->delete('domain-1');
        $verified = $client->domains()->verify('domain-1');
        $records = $client->domains()->dnsRecords('domain-1');
        $status = $client->domains()->status('domain-1');

        self::assertSame('mail.example.com', $created->data()['domain']);
        self::assertInstanceOf(Collection::class, $domains);
        self::assertSame('domain-1', $domains->first()['id']);
        self::assertSame(3, $domains->pagination()?->total);
        self::assertSame('pending', $retrieved->data()['verification_status']);
        self::assertTrue($deleted->success());
        self::assertTrue($verified->data()['verified']);
        self::assertSame('TXT', $records->first()['record_type']);
        self::assertSame('pending', $status->data()['dns_status']);
        self::assertArrayNotHasKey('dns_records', $status->data());

        $create = $this->historyRequest($history, 0);
        self::assertSame('POST', $create->getMethod());
        self::assertSame('mail.example.com', $this->body($create)['domain']);
        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertSame('pending', $query['status']);
        self::assertSame('/api/v1/domains/domain-1', $this->historyRequest($history, 2)->getUri()->getPath());
        self::assertSame('DELETE', $this->historyRequest($history, 3)->getMethod());
        self::assertSame('/api/v1/domains/domain-1/verify', $this->historyRequest($history, 4)->getUri()->getPath());
        self::assertSame('/api/v1/domains/domain-1', $this->historyRequest($history, 5)->getUri()->getPath());
        self::assertSame('/api/v1/domains/domain-1', $this->historyRequest($history, 6)->getUri()->getPath());
    }

    public function test_domain_verification_errors_are_mapped(): void
    {
        $client = $this->mockClient([
            $this->mockJsonResponse(503, [
                'success' => false,
                'message' => 'DNS provider is unavailable.',
            ]),
        ]);

        try {
            $client->domains()->verify('domain-1');
            self::fail('Expected an ApiException.');
        } catch (ApiException $exception) {
            self::assertSame(503, $exception->getStatusCode());
            self::assertSame('DNS provider is unavailable.', $exception->getMessage());
            self::assertTrue($exception->isServerError());
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
                'total' => 3,
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
