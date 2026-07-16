<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTimeInterface;
use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\MessagesApi;

/**
 * Messages resource (delivery logs).
 *
 * Inspect outbound message delivery logs and related filters.
 *
 * @example
 * $logs = $mm->messages()->list([
 *     'status' => 'delivered',
 *     'from' => '2026-01-01',
 * ]);
 *
 * $message = $mm->messages()->get($messageId);
 */
final class Messages extends BaseResource
{
    private ?MessagesApi $api = null;

    /**
     * List delivery logs with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     provider?: string,
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     page?: int,
     *     per_page?: int
     * } $filters Delivery-log filters.
     * @return Collection A collection of delivery logs with pagination.
     *
     * @throws ApiException When delivery logs cannot be listed.
     *
     * @example
     * $logs = $mm->messages()->list([
     *     'status' => 'delivered',
     *     'page' => 1,
     * ]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listMessagesRequest(
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            $filters['provider'] ?? null,
            $this->normalizeDate($filters['from'] ?? null, 'from'),
            $this->normalizeDate($filters['to'] ?? null, 'to'),
            isset($filters['page']) ? (int) $filters['page'] : null,
            isset($filters['per_page']) ? (int) $filters['per_page'] : null,
        ));
    }

    /**
     * Retrieve a delivery log by message UUID.
     *
     * @param  string  $messageId  Message UUID.
     * @return Response Delivery-log detail.
     *
     * @throws ApiException When the delivery log cannot be retrieved.
     *
     * @example
     * $log = $mm->messages()->get($messageId);
     */
    public function get(string $messageId): Response
    {
        return $this->executeRequest($this->api()->getMessageRequest($messageId));
    }

    /**
     * Search delivery logs by recipient or content query.
     *
     * @param  string  $query  Search string.
     * @param array{
     *     status?: string,
     *     provider?: string,
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     page?: int,
     *     per_page?: int
     * } $filters Additional filters.
     * @return Collection Matching delivery logs.
     *
     * @throws ApiException When search fails.
     *
     * @example
     * $logs = $mm->messages()->search('john@example.com');
     */
    public function search(string $query, array $filters = []): Collection
    {
        return $this->list(['search' => $query, ...$filters]);
    }

    /**
     * Filter delivery logs.
     *
     * Alias of {@see list()} for fluent filter workflows.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     provider?: string,
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     page?: int,
     *     per_page?: int
     * } $filters Delivery-log filters.
     * @return Collection Filtered delivery logs.
     *
     * @throws ApiException When filtering fails.
     *
     * @example
     * $logs = $mm->messages()->filter(['status' => 'bounced']);
     */
    public function filter(array $filters = []): Collection
    {
        return $this->list($filters);
    }

    /**
     * Retrieve lifecycle events for a message.
     *
     * @param  string  $messageId  Message UUID.
     * @return Collection Message events.
     *
     * @throws ApiException When events cannot be retrieved.
     *
     * @example
     * $events = $mm->messages()->events($messageId);
     */
    public function events(string $messageId): Collection
    {
        return $this->executeCollectionRequest(
            $this->api()->messageEventsRequest($messageId)
        );
    }

    /**
     * Retrieve the event timeline for a message.
     *
     * Alias of {@see events()}.
     *
     * @param  string  $messageId  Message UUID.
     * @return Collection Timeline events.
     *
     * @throws ApiException When the timeline cannot be retrieved.
     *
     * @example
     * $timeline = $mm->messages()->timeline($messageId);
     */
    public function timeline(string $messageId): Collection
    {
        return $this->events($messageId);
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

    private function api(): MessagesApi
    {
        return $this->api ??= new MessagesApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
