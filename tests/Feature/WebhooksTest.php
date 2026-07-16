<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\ValidationException;
use MailerMine\Resources\Webhooks;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class WebhooksTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_webhook_crud_deliveries_replay_and_verification(): void
    {
        $history = [];
        $webhook = [
            'id' => 'webhook-1',
            'name' => 'Production events',
            'url' => 'https://example.com/hooks',
            'is_active' => true,
            'subscribed_events' => ['email.delivered'],
        ];
        $delivery = [
            'id' => 'delivery-1',
            'status' => 'failed',
            'event_type' => 'email.delivered',
            'http_status' => 500,
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource([
                ...$webhook,
                'signing_secret' => 'whsec_test',
            ])),
            $this->mockJsonResponse(200, $this->list([$webhook])),
            $this->mockJsonResponse(200, $this->resource($webhook)),
            $this->mockJsonResponse(200, $this->resource([
                ...$webhook,
                'subscribed_events' => ['email.delivered', 'email.bounced'],
            ])),
            $this->mockJsonResponse(200, $this->resource($delivery)),
            $this->mockJsonResponse(200, $this->resource([
                ...$webhook,
                'signing_secret' => 'whsec_rotated',
            ])),
            $this->mockJsonResponse(200, $this->list([$delivery])),
            $this->mockJsonResponse(200, $this->resource($delivery)),
            $this->mockJsonResponse(200, $this->list([$delivery])),
            $this->mockJsonResponse(200, $this->list([$delivery])),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Replay queued.',
                'data' => ['queued' => 1],
            ]),
            $this->mockJsonResponse(200, $this->resource([
                ...$delivery,
                'status' => 'pending',
            ])),
            $this->mockJsonResponse(200, $this->resource([...$webhook, 'is_active' => false])),
            $this->mockJsonResponse(200, $this->resource([...$webhook, 'is_active' => true])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
        ], $history);

        $created = $client->webhooks()->create([
            'name' => 'Production events',
            'url' => 'https://example.com/hooks',
            'subscribed_events' => ['email.delivered'],
        ]);
        $listed = $client->webhooks()->list(['status' => 'active', 'page' => 1]);
        $retrieved = $client->webhooks()->get('webhook-1');
        $updated = $client->webhooks()->update('webhook-1', [
            'subscribed_events' => ['email.delivered', 'email.bounced'],
        ]);
        $tested = $client->webhooks()->test('webhook-1', ['event_type' => 'email.delivered']);
        $rotated = $client->webhooks()->rotateSecret('webhook-1');
        $deliveries = $client->webhooks()->deliveries('webhook-1', ['status' => 'failed']);
        $deliveryResponse = $client->webhooks()->delivery('delivery-1');
        $logs = $client->webhooks()->logs('webhook-1');
        $failures = $client->webhooks()->failures('webhook-1');
        $replayed = $client->webhooks()->replay('webhook-1', ['failed_only' => true]);
        $retried = $client->webhooks()->retry('delivery-1');
        $disabled = $client->webhooks()->disable('webhook-1');
        $enabled = $client->webhooks()->enable('webhook-1');
        $deleted = $client->webhooks()->delete('webhook-1');

        self::assertSame('whsec_test', $created->data()['signing_secret']);
        self::assertInstanceOf(Collection::class, $listed);
        self::assertSame('webhook-1', $retrieved->data()['id']);
        self::assertSame(['email.delivered', 'email.bounced'], $updated->data()['subscribed_events']);
        self::assertSame('failed', $tested->data()['status']);
        self::assertSame('whsec_rotated', $rotated->data()['signing_secret']);
        self::assertSame('delivery-1', $deliveries->first()['id']);
        self::assertSame(500, $deliveryResponse->data()['http_status']);
        self::assertSame(1, $logs->count());
        self::assertSame('failed', $failures->first()['status']);
        self::assertSame(1, $replayed->data()['queued']);
        self::assertSame('pending', $retried->data()['status']);
        self::assertFalse($disabled->data()['is_active']);
        self::assertTrue($enabled->data()['is_active']);
        self::assertTrue($deleted->success());

        self::assertSame('/api/v1/webhooks', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame(['name' => 'Production events', 'url' => 'https://example.com/hooks', 'subscribed_events' => ['email.delivered']], $this->body($this->historyRequest($history, 0)));
        self::assertSame('/api/v1/webhooks/webhook-1/test', $this->historyRequest($history, 4)->getUri()->getPath());
        self::assertSame('/api/v1/webhooks/webhook-1/rotate-secret', $this->historyRequest($history, 5)->getUri()->getPath());
        self::assertSame('/api/v1/webhooks/webhook-1/deliveries', $this->historyRequest($history, 6)->getUri()->getPath());
        self::assertSame('/api/v1/webhook-deliveries/delivery-1', $this->historyRequest($history, 7)->getUri()->getPath());
        self::assertSame('/api/v1/webhooks/webhook-1/replay', $this->historyRequest($history, 10)->getUri()->getPath());
        self::assertTrue($this->body($this->historyRequest($history, 10))['failed_only']);
        self::assertSame('/api/v1/webhook-deliveries/delivery-1/replay', $this->historyRequest($history, 11)->getUri()->getPath());

        $payload = '{"type":"email.delivered"}';
        $secret = 'whsec_test';
        $signature = hash_hmac('sha256', $payload, $secret);
        self::assertTrue(Webhooks::verify($payload, $signature, $secret));
        self::assertTrue(Webhooks::verify($payload, 'sha256='.$signature, $secret));
        self::assertFalse(Webhooks::verify($payload, 'invalid', $secret));
    }

    public function test_validation_exception_is_mapped(): void
    {
        $history = [];
        $client = $this->mockClient([
            $this->mockJsonResponse(422, [
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => ['url' => ['The url field is required.']],
            ]),
        ], $history);

        $this->expectException(ValidationException::class);
        $client->webhooks()->create([
            'name' => 'Broken',
            'url' => '',
            'subscribed_events' => ['email.delivered'],
        ]);
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
