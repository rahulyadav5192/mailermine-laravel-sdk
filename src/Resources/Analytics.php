<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTimeInterface;
use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\AnalyticsApi;

/**
 * Analytics resource.
 *
 * Global platform analytics over date ranges. Campaign-scoped metrics are
 * available through {@see Campaigns} when a `campaign` filter is provided.
 *
 * @example
 * $overview = $mm->analytics()->overview([
 *     'from' => '2026-01-01',
 *     'to' => '2026-01-31',
 * ]);
 *
 * $opens = $mm->analytics()->opens([
 *     'from' => '2026-01-01',
 *     'to' => '2026-01-31',
 * ]);
 */
final class Analytics extends BaseResource
{
    private ?AnalyticsApi $api = null;

    /**
     * Retrieve the analytics overview for a date range.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string,
     *     project?: string,
     *     project_id?: string,
     *     domain?: string,
     *     domain_id?: string
     * } $filters Analytics filters. Global endpoints accept `from`/`to`.
     *        When `campaign` is set, campaign analytics are returned instead.
     * @return Response Overview metrics.
     *
     * @throws ApiException When analytics cannot be retrieved.
     *
     * @example
     * $overview = $mm->analytics()->overview([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function overview(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->analytics($campaignId);
        }

        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsOverviewRequest($from, $to));
    }

    /**
     * Retrieve delivery metrics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string
     * } $filters Analytics filters.
     * @return Response Delivery-focused metrics.
     *
     * @throws ApiException When delivery metrics cannot be retrieved.
     *
     * @example
     * $deliveries = $mm->analytics()->deliveries([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function deliveries(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->deliveries($campaignId);
        }

        return $this->messagesSlice($filters, [
            'sent',
            'delivered',
        ]);
    }

    /**
     * Retrieve open metrics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string
     * } $filters Analytics filters.
     * @return Response Open-focused metrics.
     *
     * @throws ApiException When open metrics cannot be retrieved.
     *
     * @example
     * $opens = $mm->analytics()->opens([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function opens(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->opens($campaignId);
        }

        return $this->engagementSlice($filters, [
            'opens',
            'unique_opens',
            'open_rate',
            'sent',
            'delivered',
        ]);
    }

    /**
     * Retrieve click metrics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string
     * } $filters Analytics filters.
     * @return Response Click-focused metrics.
     *
     * @throws ApiException When click metrics cannot be retrieved.
     *
     * @example
     * $clicks = $mm->analytics()->clicks([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function clicks(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->clicks($campaignId);
        }

        return $this->engagementSlice($filters, [
            'clicks',
            'unique_clicks',
            'ctr',
            'ctor',
            'sent',
            'delivered',
        ]);
    }

    /**
     * Retrieve bounce metrics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string
     * } $filters Analytics filters.
     * @return Response Bounce-focused metrics.
     *
     * @throws ApiException When bounce metrics cannot be retrieved.
     *
     * @example
     * $bounces = $mm->analytics()->bounces([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function bounces(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->bounces($campaignId);
        }

        return $this->messagesSlice($filters, [
            'bounced',
            'sent',
            'delivered',
        ]);
    }

    /**
     * Retrieve complaint metrics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string
     * } $filters Analytics filters.
     * @return Response Complaint-focused metrics.
     *
     * @throws ApiException When complaint metrics cannot be retrieved.
     *
     * @example
     * $complaints = $mm->analytics()->complaints([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function complaints(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->complaints($campaignId);
        }

        return $this->messagesSlice($filters, [
            'complained',
            'sent',
            'delivered',
        ]);
    }

    /**
     * Retrieve unsubscribe metrics.
     *
     * Global analytics do not expose an unsubscribe aggregate. When a campaign
     * filter is provided, campaign analytics are used. Otherwise unsubscribe
     * events are queried for the range.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string,
     *     per_page?: int
     * } $filters Analytics filters.
     * @return Response Unsubscribe metrics or event summary.
     *
     * @throws ApiException When unsubscribe metrics cannot be retrieved.
     *
     * @example
     * $unsubscribes = $mm->analytics()->unsubscribes([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function unsubscribes(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->unsubscribes($campaignId);
        }

        $events = $this->client->events()->list([
            'event_type' => 'email.unsubscribed',
            'from' => $filters['from'] ?? null,
            'to' => $filters['to'] ?? null,
            'per_page' => $filters['per_page'] ?? 100,
        ]);

        return Response::from([
            'success' => true,
            'message' => 'OK',
            'data' => [
                'count' => $events->count(),
                'events' => $events->all(),
            ],
            'meta' => $events->pagination()?->toArray(),
        ]);
    }

    /**
     * Retrieve usage-oriented analytics.
     *
     * Combines message totals for the requested range.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     campaign?: string,
     *     campaign_id?: string
     * } $filters Analytics filters.
     * @return Response Usage metrics.
     *
     * @throws ApiException When usage metrics cannot be retrieved.
     *
     * @example
     * $usage = $mm->analytics()->usage([
     *     'from' => '2026-01-01',
     *     'to' => '2026-01-31',
     * ]);
     */
    public function usage(array $filters = []): Response
    {
        if (($campaignId = $this->campaignFilter($filters)) !== null) {
            return $this->client->campaigns()->delivery($campaignId);
        }

        $messages = $this->messages($filters);
        $totals = $messages->data()['totals'] ?? $messages->data();
        $totals = is_array($totals) ? $totals : [];

        return Response::from([
            'success' => $messages->success() ?? true,
            'message' => $messages->message() ?? 'OK',
            'data' => [
                'sent' => $totals['sent'] ?? 0,
                'delivered' => $totals['delivered'] ?? 0,
                'opened' => $totals['opened'] ?? 0,
                'clicked' => $totals['clicked'] ?? 0,
                'bounced' => $totals['bounced'] ?? 0,
                'complained' => $totals['complained'] ?? 0,
            ],
        ]);
    }

    /**
     * Retrieve recent analytics activity.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Collection Recent activity entries.
     *
     * @throws ApiException When activity cannot be retrieved.
     *
     * @example
     * foreach ($mm->analytics()->activity(['from' => '2026-01-01']) as $item) {
     *     echo $item['event_type'] ?? '';
     * }
     */
    public function activity(array $filters = []): Collection
    {
        $overview = $this->overview($filters);
        $data = $overview->data();
        $data = is_array($data) ? $data : [];
        $activity = $data['recent_activity'] ?? [];

        return new Collection(is_array($activity) ? array_values($activity) : []);
    }

    /**
     * Retrieve message analytics for a date range.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Response Message analytics payload.
     *
     * @throws ApiException When message analytics cannot be retrieved.
     *
     * @example
     * $messages = $mm->analytics()->messages(['from' => '2026-01-01']);
     */
    public function messages(array $filters = []): Response
    {
        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsMessagesRequest($from, $to));
    }

    /**
     * Retrieve engagement analytics for a date range.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Response Engagement analytics payload.
     *
     * @throws ApiException When engagement analytics cannot be retrieved.
     *
     * @example
     * $engagement = $mm->analytics()->engagement(['from' => '2026-01-01']);
     */
    public function engagement(array $filters = []): Response
    {
        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsEngagementRequest($from, $to));
    }

    /**
     * Retrieve campaign ranking analytics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Response Campaign analytics breakdown.
     *
     * @throws ApiException When campaign analytics cannot be retrieved.
     *
     * @example
     * $campaigns = $mm->analytics()->campaigns(['from' => '2026-01-01']);
     */
    public function campaigns(array $filters = []): Response
    {
        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsCampaignsRequest($from, $to));
    }

    /**
     * Retrieve domain analytics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Response Domain analytics breakdown.
     *
     * @throws ApiException When domain analytics cannot be retrieved.
     *
     * @example
     * $domains = $mm->analytics()->domains(['from' => '2026-01-01']);
     */
    public function domains(array $filters = []): Response
    {
        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsDomainsRequest($from, $to));
    }

    /**
     * Retrieve project analytics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Response Project analytics breakdown.
     *
     * @throws ApiException When project analytics cannot be retrieved.
     *
     * @example
     * $projects = $mm->analytics()->projects(['from' => '2026-01-01']);
     */
    public function projects(array $filters = []): Response
    {
        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsProjectsRequest($from, $to));
    }

    /**
     * Retrieve provider analytics.
     *
     * @param array{
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null
     * } $filters Analytics filters.
     * @return Response Provider analytics breakdown.
     *
     * @throws ApiException When provider analytics cannot be retrieved.
     *
     * @example
     * $providers = $mm->analytics()->providers(['from' => '2026-01-01']);
     */
    public function providers(array $filters = []): Response
    {
        [$from, $to] = $this->normalizeRange($filters);

        return $this->executeRequest($this->api()->analyticsProvidersRequest($from, $to));
    }

    /**
     * @param  array<string, mixed>  $filters
     * @param  list<string>  $keys
     */
    private function messagesSlice(array $filters, array $keys): Response
    {
        $response = $this->messages($filters);
        $data = $response->data();
        $data = is_array($data) ? $data : [];
        $totals = is_array($data['totals'] ?? null) ? $data['totals'] : $data;

        return Response::from([
            'success' => $response->success() ?? true,
            'message' => $response->message() ?? 'OK',
            'data' => array_intersect_key($totals, array_flip($keys)),
        ]);
    }

    /**
     * @param  array<string, mixed>  $filters
     * @param  list<string>  $keys
     */
    private function engagementSlice(array $filters, array $keys): Response
    {
        $response = $this->engagement($filters);
        $data = $response->data();
        $data = is_array($data) ? $data : [];

        return Response::from([
            'success' => $response->success() ?? true,
            'message' => $response->message() ?? 'OK',
            'data' => array_intersect_key($data, array_flip($keys)),
        ]);
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array{0: ?string, 1: ?string}
     */
    private function normalizeRange(array $filters): array
    {
        return [
            $this->normalizeDate($filters['from'] ?? null, 'from'),
            $this->normalizeDate($filters['to'] ?? null, 'to'),
        ];
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    private function campaignFilter(array $filters): ?string
    {
        $campaignId = $filters['campaign'] ?? $filters['campaign_id'] ?? null;

        return is_string($campaignId) && $campaignId !== '' ? $campaignId : null;
    }

    private function normalizeDate(mixed $value, string $field): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format(DateTimeInterface::ATOM);
        }

        if (is_string($value)) {
            return $value;
        }

        throw new InvalidArgumentException(
            sprintf('The %s filter must be an ISO-8601 string or DateTimeInterface.', $field)
        );
    }

    private function api(): AnalyticsApi
    {
        return $this->api ??= new AnalyticsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
