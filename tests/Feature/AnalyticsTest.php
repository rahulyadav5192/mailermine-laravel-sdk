<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;

final class AnalyticsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_overview_and_metric_slices_map_requests(): void
    {
        $history = [];
        $overview = [
            'emails_sent' => 1000,
            'campaigns' => 12,
            'delivery_rate' => 0.97,
            'open_rate' => 0.42,
            'click_rate' => 0.11,
            'bounce_rate' => 0.02,
            'complaint_rate' => 0.01,
            'recent_activity' => [
                ['event_type' => 'email.opened', 'email' => 'john@example.com'],
            ],
        ];
        $messages = [
            'totals' => [
                'sent' => 1000,
                'delivered' => 970,
                'opened' => 420,
                'clicked' => 110,
                'bounced' => 20,
                'complained' => 5,
            ],
        ];
        $engagement = [
            'opens' => 420,
            'unique_opens' => 380,
            'clicks' => 110,
            'unique_clicks' => 90,
            'open_rate' => 0.42,
            'ctr' => 0.11,
            'ctor' => 0.26,
            'sent' => 1000,
            'delivered' => 970,
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(200, $this->resource($overview)),
            $this->mockJsonResponse(200, $this->resource($messages)),
            $this->mockJsonResponse(200, $this->resource($engagement)),
            $this->mockJsonResponse(200, $this->resource($engagement)),
            $this->mockJsonResponse(200, $this->resource($messages)),
            $this->mockJsonResponse(200, $this->resource($messages)),
            $this->mockJsonResponse(200, $this->resource($messages)),
            $this->mockJsonResponse(200, $this->resource($overview)),
            $this->mockJsonResponse(200, $this->list([
                ['id' => 'event-1', 'event_type' => 'email.unsubscribed'],
            ])),
            $this->mockJsonResponse(200, $this->resource(['campaigns' => [['name' => 'March']]])),
            $this->mockJsonResponse(200, $this->resource(['domains' => [['domain' => 'mail.example.com']]])),
            $this->mockJsonResponse(200, $this->resource(['projects' => [['name' => 'Production']]])),
        ], $history);

        $overviewResponse = $client->analytics()->overview([
            'from' => '2026-01-01',
            'to' => '2026-01-31',
        ]);
        $deliveries = $client->analytics()->deliveries(['from' => '2026-01-01']);
        $opens = $client->analytics()->opens(['from' => '2026-01-01']);
        $clicks = $client->analytics()->clicks(['from' => '2026-01-01']);
        $bounces = $client->analytics()->bounces(['from' => '2026-01-01']);
        $complaints = $client->analytics()->complaints(['from' => '2026-01-01']);
        $usage = $client->analytics()->usage(['from' => '2026-01-01']);
        $activity = $client->analytics()->activity(['from' => '2026-01-01']);
        $unsubscribes = $client->analytics()->unsubscribes(['from' => '2026-01-01']);
        $campaigns = $client->analytics()->campaigns(['from' => '2026-01-01']);
        $domains = $client->analytics()->domains(['from' => '2026-01-01']);
        $projects = $client->analytics()->projects(['from' => '2026-01-01']);

        self::assertSame(1000, $overviewResponse->data()['emails_sent']);
        self::assertSame(970, $deliveries->data()['delivered']);
        self::assertSame(420, $opens->data()['opens']);
        self::assertSame(110, $clicks->data()['clicks']);
        self::assertSame(20, $bounces->data()['bounced']);
        self::assertSame(5, $complaints->data()['complained']);
        self::assertSame(1000, $usage->data()['sent']);
        self::assertInstanceOf(Collection::class, $activity);
        self::assertSame('email.opened', $activity->first()['event_type']);
        self::assertSame(1, $unsubscribes->data()['count']);
        self::assertSame('March', $campaigns->data()['campaigns'][0]['name']);
        self::assertSame('mail.example.com', $domains->data()['domains'][0]['domain']);
        self::assertSame('Production', $projects->data()['projects'][0]['name']);

        self::assertSame('/api/v1/analytics/overview', $this->historyRequest($history, 0)->getUri()->getPath());
        parse_str($this->historyRequest($history, 0)->getUri()->getQuery(), $query);
        self::assertStringContainsString('2026-01-01', $query['from']);
        self::assertSame('/api/v1/analytics/messages', $this->historyRequest($history, 1)->getUri()->getPath());
        self::assertSame('/api/v1/analytics/engagement', $this->historyRequest($history, 2)->getUri()->getPath());
        self::assertSame('/api/v1/events', $this->historyRequest($history, 8)->getUri()->getPath());
        parse_str($this->historyRequest($history, 8)->getUri()->getQuery(), $eventQuery);
        self::assertSame('email.unsubscribed', $eventQuery['event_type']);
    }

    public function test_campaign_filter_delegates_to_campaign_analytics(): void
    {
        $history = [];
        $client = $this->mockClient([
            $this->mockJsonResponse(200, [
                'data' => [
                    'opened' => 40,
                    'unique_opens' => 35,
                    'open_rate' => 0.4,
                ],
            ]),
        ], $history);

        $opens = $client->analytics()->opens(['campaign' => 'campaign-1']);

        self::assertSame(40, $opens->data()['opened']);
        self::assertSame('/api/v1/campaigns/campaign-1/analytics', $this->historyRequest($history, 0)->getUri()->getPath());
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
}
