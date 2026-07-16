<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use DateTimeImmutable;
use InvalidArgumentException;
use MailerMine\Exceptions\NotFoundException;
use MailerMine\Exceptions\ValidationException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class CampaignsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_campaign_crud_content_and_recipients_map_requests(): void
    {
        $history = [];
        $campaign = [
            'uuid' => 'campaign-1',
            'name' => 'March Newsletter',
            'subject' => 'Hello',
            'status' => 'draft',
            'status_label' => 'Draft',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource($campaign)),
            $this->mockJsonResponse(200, $this->resource([
                ...$campaign,
                'subject' => 'What is new',
                'template' => ['uuid' => 'template-1'],
                'segment' => ['uuid' => 'segment-1'],
            ])),
            $this->mockJsonResponse(200, $this->list([$campaign])),
            $this->mockJsonResponse(200, $this->resource($campaign)),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'subject' => 'Updated'])),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Preview ready.',
                'data' => [
                    'subject' => 'What is new',
                    'html' => '<h1>Hi</h1>',
                    'text' => 'Hi',
                    'preview_text' => 'Inbox teaser',
                ],
            ]),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'template' => ['uuid' => 'template-2']])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'subject' => 'Fresh subject'])),
            $this->mockJsonResponse(200, $this->resource([
                ...$campaign,
                'from_name' => 'MailerMine',
                'from_email' => 'hello@mailermine.com',
            ])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'reply_to' => 'support@mailermine.com'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'preview_text' => 'Teaser'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'segment' => ['uuid' => 'segment-2']])),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Recipient preview ready.',
                'data' => [
                    'estimated_count' => 42,
                    'subscribed_count' => 40,
                    'unsubscribed_count' => 1,
                    'suppressed_count' => 1,
                    'sample_contacts' => [['email' => 'john@example.com']],
                ],
            ]),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Recipient preview ready.',
                'data' => [
                    'estimated_count' => 42,
                    'subscribed_count' => 40,
                    'unsubscribed_count' => 1,
                    'suppressed_count' => 1,
                ],
            ]),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'uuid' => 'campaign-2'])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
        ], $history);

        $created = $client->campaigns()->create([
            'name' => 'March Newsletter',
            'subject' => 'What is new',
            'template_id' => 'template-1',
            'segment_id' => 'segment-1',
            'preheader' => 'Inbox teaser',
        ]);
        $listed = $client->campaigns()->list(['status' => 'draft', 'page' => 1]);
        $retrieved = $client->campaigns()->get('campaign-1');
        $updated = $client->campaigns()->update('campaign-1', ['subject' => 'Updated']);
        $preview = $client->campaigns()->preview('campaign-1');
        $client->campaigns()->setTemplate('campaign-1', 'template-2');
        $client->campaigns()->setSubject('campaign-1', 'Fresh subject');
        $client->campaigns()->setSender('campaign-1', [
            'from_name' => 'MailerMine',
            'from_email' => 'hello@mailermine.com',
        ]);
        $client->campaigns()->setReplyTo('campaign-1', 'support@mailermine.com');
        $client->campaigns()->setPreheader('campaign-1', 'Teaser');
        $client->campaigns()->addSegment('campaign-1', 'segment-2');
        $recipients = $client->campaigns()->previewRecipients('campaign-1');
        $count = $client->campaigns()->recipientCount('campaign-1');
        $duplicated = $client->campaigns()->duplicate('campaign-1');
        $deleted = $client->campaigns()->delete('campaign-1');

        self::assertSame('campaign-1', $created->data()['uuid']);
        self::assertSame('What is new', $created->data()['subject']);
        self::assertInstanceOf(Collection::class, $listed);
        self::assertSame(1, $listed->pagination()?->currentPage);
        self::assertSame('campaign-1', $retrieved->data()['uuid']);
        self::assertSame('Updated', $updated->data()['subject']);
        self::assertSame('<h1>Hi</h1>', $preview->data()['html']);
        self::assertSame(42, $recipients->data()['estimated_count']);
        self::assertSame(42, $count->data()['count']);
        self::assertSame('campaign-2', $duplicated->data()['uuid']);
        self::assertTrue($deleted->success());

        self::assertSame('POST', $this->historyRequest($history, 0)->getMethod());
        self::assertSame('/api/v1/campaigns', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame(['name' => 'March Newsletter'], $this->body($this->historyRequest($history, 0)));

        self::assertSame('PATCH', $this->historyRequest($history, 1)->getMethod());
        self::assertSame('/api/v1/campaigns/campaign-1', $this->historyRequest($history, 1)->getUri()->getPath());
        self::assertSame([
            'subject' => 'What is new',
            'preview_text' => 'Inbox teaser',
            'template_uuid' => 'template-1',
            'segment_uuid' => 'segment-1',
        ], $this->body($this->historyRequest($history, 1)));

        parse_str($this->historyRequest($history, 2)->getUri()->getQuery(), $query);
        self::assertSame('draft', $query['status']);
        self::assertSame('template-2', $this->body($this->historyRequest($history, 6))['template_uuid']);
        self::assertSame('segment-2', $this->body($this->historyRequest($history, 11))['segment_uuid']);
    }

    public function test_scheduling_and_lifecycle_actions(): void
    {
        $history = [];
        $campaign = [
            'uuid' => 'campaign-1',
            'name' => 'March Newsletter',
            'status' => 'scheduled',
            'status_label' => 'Scheduled',
            'scheduled_at' => '2026-08-01T09:00:00+00:00',
            'timezone' => 'UTC',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'ready'])),
            $this->mockJsonResponse(200, $this->resource($campaign)),
            $this->mockJsonResponse(200, $this->resource([
                ...$campaign,
                'scheduled_at' => '2026-08-02T10:00:00+00:00',
            ])),
            $this->mockJsonResponse(200, $this->resource([
                ...$campaign,
                'status' => 'ready',
                'scheduled_at' => null,
            ])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'sending'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'sending'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'paused'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'sending'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'cancelled'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'archived'])),
            $this->mockJsonResponse(200, $this->resource([...$campaign, 'status' => 'draft'])),
            $this->mockJsonResponse(200, $this->resource($campaign)),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Progress.',
                'data' => [
                    'status' => 'sending',
                    'completion_percentage' => 55.5,
                    'sent_count' => 100,
                ],
            ]),
        ], $history);

        $ready = $client->campaigns()->markReady('campaign-1');
        $scheduled = $client->campaigns()->schedule('campaign-1', [
            'scheduled_at' => new DateTimeImmutable('2026-08-01T09:00:00+00:00'),
            'timezone' => 'America/New_York',
        ]);
        $rescheduled = $client->campaigns()->reschedule('campaign-1', [
            'scheduled_at' => '2026-08-02T10:00:00+00:00',
            'timezone' => 'UTC',
        ]);
        $unscheduled = $client->campaigns()->unschedule('campaign-1');
        $sentNow = $client->campaigns()->sendNow('campaign-1', ['timezone' => 'UTC']);
        $sent = $client->campaigns()->send('campaign-1');
        $paused = $client->campaigns()->pause('campaign-1');
        $resumed = $client->campaigns()->resume('campaign-1');
        $cancelled = $client->campaigns()->cancel('campaign-1');
        $archived = $client->campaigns()->archive('campaign-1');
        $restored = $client->campaigns()->restore('campaign-1');
        $status = $client->campaigns()->status('campaign-1');
        $progress = $client->campaigns()->progress('campaign-1');

        self::assertSame('ready', $ready->data()['status']);
        self::assertSame('scheduled', $scheduled->data()['status']);
        self::assertSame('2026-08-02T10:00:00+00:00', $rescheduled->data()['scheduled_at']);
        self::assertNull($unscheduled->data()['scheduled_at']);
        self::assertSame('sending', $sentNow->data()['status']);
        self::assertSame('sending', $sent->data()['status']);
        self::assertSame('paused', $paused->data()['status']);
        self::assertSame('sending', $resumed->data()['status']);
        self::assertSame('cancelled', $cancelled->data()['status']);
        self::assertSame('archived', $archived->data()['status']);
        self::assertSame('draft', $restored->data()['status']);
        self::assertSame('scheduled', $status->data()['status']);
        self::assertSame(55.5, $progress->data()['completion_percentage']);

        self::assertSame('/api/v1/campaigns/campaign-1/mark-ready', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/schedule', $this->historyRequest($history, 1)->getUri()->getPath());
        $scheduleBody = $this->body($this->historyRequest($history, 1));
        self::assertFalse($scheduleBody['send_immediately']);
        self::assertSame('America/New_York', $scheduleBody['timezone']);
        self::assertSame('2026-08-01T09:00:00+00:00', $scheduleBody['scheduled_at']);

        self::assertTrue($this->body($this->historyRequest($history, 4))['send_immediately']);
        self::assertSame('/api/v1/campaigns/campaign-1/send', $this->historyRequest($history, 5)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/pause', $this->historyRequest($history, 6)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/resume', $this->historyRequest($history, 7)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/cancel', $this->historyRequest($history, 8)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/archive', $this->historyRequest($history, 9)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/restore', $this->historyRequest($history, 10)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/progress', $this->historyRequest($history, 12)->getUri()->getPath());
    }

    public function test_analytics_and_events_map_responses(): void
    {
        $history = [];
        $analytics = [
            'recipients' => 100,
            'queued' => 0,
            'sent' => 100,
            'delivered' => 95,
            'opened' => 40,
            'unique_opens' => 35,
            'clicked' => 12,
            'unique_clicks' => 10,
            'bounced' => 3,
            'complained' => 1,
            'failed' => 2,
            'unsubscribed' => 4,
            'delivery_rate' => 0.95,
            'open_rate' => 0.4,
            'click_rate' => 0.12,
            'bounce_rate' => 0.03,
            'complaint_rate' => 0.01,
            'failure_rate' => 0.02,
            'unsubscribe_rate' => 0.04,
            'average_delivery_time_seconds' => 1.5,
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [['url' => 'https://example.com', 'clicks' => 5]],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'data' => $analytics,
                'top_links' => [],
            ]),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Links.',
                'data' => [['url' => 'https://example.com', 'clicks' => 5]],
            ]),
            $this->mockJsonResponse(200, [
                'data' => [
                    ['type' => 'opened', 'email' => 'john@example.com'],
                ],
            ]),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Activities.',
                'data' => [
                    ['event' => 'started', 'created_at' => '2026-08-01T09:00:00+00:00'],
                ],
            ]),
            $this->mockJsonResponse(200, [
                'success' => true,
                'message' => 'Timeline.',
                'data' => [
                    ['label' => 'Queued', 'at' => '2026-08-01T09:00:00+00:00'],
                ],
            ]),
            $this->mockJsonResponse(200, $this->list([
                ['uuid' => 'recipient-1', 'email' => 'john@example.com', 'status' => 'delivered'],
            ])),
        ], $history);

        $analyticsResponse = $client->campaigns()->analytics('campaign-1');
        $opens = $client->campaigns()->opens('campaign-1');
        $clicks = $client->campaigns()->clicks('campaign-1');
        $bounces = $client->campaigns()->bounces('campaign-1');
        $complaints = $client->campaigns()->complaints('campaign-1');
        $unsubscribes = $client->campaigns()->unsubscribes('campaign-1');
        $deliveries = $client->campaigns()->deliveries('campaign-1');
        $delivery = $client->campaigns()->delivery('campaign-1');
        $links = $client->campaigns()->links('campaign-1');
        $events = $client->campaigns()->events('campaign-1');
        $activity = $client->campaigns()->activity('campaign-1');
        $timeline = $client->campaigns()->timeline('campaign-1');
        $recipients = $client->campaigns()->recipients('campaign-1', ['status' => 'delivered']);

        self::assertSame(95, $analyticsResponse->data()['delivered']);
        self::assertSame([['url' => 'https://example.com', 'clicks' => 5]], $analyticsResponse->toArray()['top_links']);
        self::assertSame(40, $opens->data()['opened']);
        self::assertSame(12, $clicks->data()['clicked']);
        self::assertSame(3, $bounces->data()['bounced']);
        self::assertSame(1, $complaints->data()['complained']);
        self::assertSame(4, $unsubscribes->data()['unsubscribed']);
        self::assertSame(95, $deliveries->data()['delivered']);
        self::assertSame(0.95, $delivery->data()['delivery_rate']);
        self::assertInstanceOf(Collection::class, $links);
        self::assertSame('https://example.com', $links->first()['url']);
        self::assertSame('opened', $events->first()['type']);
        self::assertSame('started', $activity->first()['event']);
        self::assertSame('Queued', $timeline->first()['label']);
        self::assertSame('john@example.com', $recipients->first()['email']);

        self::assertSame('/api/v1/campaigns/campaign-1/analytics', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/events', $this->historyRequest($history, 9)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/activities', $this->historyRequest($history, 10)->getUri()->getPath());
        self::assertSame('/api/v1/campaigns/campaign-1/timeline', $this->historyRequest($history, 11)->getUri()->getPath());
        parse_str($this->historyRequest($history, 12)->getUri()->getQuery(), $query);
        self::assertSame('delivered', $query['status']);
    }

    public function test_schedule_requires_datetime_and_maps_exceptions(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('scheduled_at');

        $history = [];
        $client = $this->mockClient([], $history);
        $client->campaigns()->schedule('campaign-1', ['timezone' => 'UTC']);
    }

    public function test_not_found_and_validation_exceptions_are_mapped(): void
    {
        $history = [];
        $client = $this->mockClient([
            $this->mockJsonResponse(404, [
                'success' => false,
                'message' => 'Campaign not found.',
            ]),
            $this->mockJsonResponse(422, [
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => ['subject' => ['Subject is required.']],
            ]),
        ], $history);

        try {
            $client->campaigns()->get('missing');
            self::fail('Expected NotFoundException.');
        } catch (NotFoundException $exception) {
            self::assertSame(404, $exception->getStatusCode());
        }

        try {
            $client->campaigns()->update('campaign-1', ['subject' => '']);
            self::fail('Expected ValidationException.');
        } catch (ValidationException $exception) {
            self::assertSame(422, $exception->getStatusCode());
            self::assertSame(['subject' => ['Subject is required.']], $exception->getErrors());
        }
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
                'per_page' => 15,
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
