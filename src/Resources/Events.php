<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTimeInterface;
use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\EventsApi;
use OpenAPI\Client\Api\MessagesApi;

/**
 * Events resource.
 *
 * Global message event querying plus helpers for message timelines.
 *
 * @example
 * $events = $mm->events()->list([
 *     'event_type' => 'email.opened',
 *     'from' => '2026-01-01',
 * ]);
 *
 * $timeline = $mm->events()->timeline($messageId);
 */
final class Events extends BaseResource
{
    private ?EventsApi $api = null;

    private ?MessagesApi $messagesApi = null;

    /**
     * List message events with filters.
     *
     * @param array{
     *     event_type?: string,
     *     source?: string,
     *     campaign?: string,
     *     campaign_id?: string,
     *     message?: string,
     *     message_id?: string,
     *     search?: string,
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     per_page?: int
     * } $filters Event list filters.
     * @return Collection A collection of events with pagination metadata when present.
     *
     * @throws ApiException When events cannot be listed.
     *
     * @example
     * $events = $mm->events()->list([
     *     'event_type' => 'email.delivered',
     *     'from' => '2026-01-01',
     * ]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listEventsRequest(
            $filters['event_type'] ?? null,
            $filters['source'] ?? null,
            $filters['campaign'] ?? $filters['campaign_id'] ?? null,
            $filters['message'] ?? $filters['message_id'] ?? null,
            $filters['search'] ?? null,
            $this->normalizeDate($filters['from'] ?? null, 'from'),
            $this->normalizeDate($filters['to'] ?? null, 'to'),
            isset($filters['per_page']) ? (int) $filters['per_page'] : null,
        ));
    }

    /**
     * Retrieve a single event by UUID.
     *
     * @param  string  $eventId  Event UUID.
     * @return Response The requested event.
     *
     * @throws ApiException When the event cannot be retrieved.
     *
     * @example
     * $event = $mm->events()->get($eventId);
     */
    public function get(string $eventId): Response
    {
        return $this->executeRequest($this->api()->getEventRequest($eventId));
    }

    /**
     * Retrieve the event timeline for a message.
     *
     * @param  string  $messageId  Message UUID.
     * @return Collection Timeline events for the message.
     *
     * @throws ApiException When the timeline cannot be retrieved.
     *
     * @example
     * $timeline = $mm->events()->timeline($messageId);
     */
    public function timeline(string $messageId): Collection
    {
        return $this->executeCollectionRequest(
            $this->messagesApi()->messageEventsRequest($messageId)
        );
    }

    /**
     * Retrieve message event history.
     *
     * Alias of {@see timeline()}.
     *
     * @param  string  $messageId  Message UUID.
     * @return Collection Message event history.
     *
     * @throws ApiException When history cannot be retrieved.
     *
     * @example
     * $history = $mm->events()->history($messageId);
     */
    public function history(string $messageId): Collection
    {
        return $this->timeline($messageId);
    }

    /**
     * Retrieve the delivery-log detail for a message.
     *
     * @param  string  $messageId  Message UUID.
     * @return Response Message delivery detail, including timeline when present.
     *
     * @throws ApiException When the message cannot be retrieved.
     *
     * @example
     * $message = $mm->events()->message($messageId);
     */
    public function message(string $messageId): Response
    {
        return $this->executeRequest($this->messagesApi()->getMessageRequest($messageId));
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

    private function api(): EventsApi
    {
        return $this->api ??= new EventsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }

    private function messagesApi(): MessagesApi
    {
        return $this->messagesApi ??= new MessagesApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
