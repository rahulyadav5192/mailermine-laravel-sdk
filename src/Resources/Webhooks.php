<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\WebhooksApi;
use OpenAPI\Client\Model\CreateWebhookRequest;
use OpenAPI\Client\Model\ReplayWebhookRequest;
use OpenAPI\Client\Model\TestWebhookRequest;
use OpenAPI\Client\Model\UpdateWebhookRequest;

/**
 * Webhooks resource.
 *
 * Manage webhook endpoints, deliveries, replay, and local signature verification.
 *
 * @example
 * $webhook = $mm->webhooks()->create([
 *     'name' => 'Production events',
 *     'url' => 'https://example.com/webhooks/mailermine',
 *     'subscribed_events' => ['email.delivered', 'email.bounced'],
 * ]);
 *
 * $secret = $webhook->data()['signing_secret'];
 */
final class Webhooks extends BaseResource
{
    private ?WebhooksApi $api = null;

    /**
     * Create a webhook endpoint.
     *
     * The signing secret is returned only on create/rotate — store it immediately.
     *
     * @param array{
     *     name: string,
     *     url: string,
     *     subscribed_events: list<string>,
     *     is_active?: bool
     * } $parameters Webhook attributes.
     * @return Response The created webhook, including signing secret.
     *
     * @throws ApiException When the webhook cannot be created.
     *
     * @example
     * $webhook = $mm->webhooks()->create([
     *     'name' => 'Production events',
     *     'url' => 'https://example.com/webhooks/mailermine',
     *     'subscribed_events' => ['email.delivered', 'email.opened'],
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateWebhookRequest::class, $parameters);

        return $this->executeRequest($this->api()->createWebhookRequest($request));
    }

    /**
     * List webhooks with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Webhook list filters.
     * @return Collection A collection of webhooks with pagination.
     *
     * @throws ApiException When webhooks cannot be listed.
     *
     * @example
     * $webhooks = $mm->webhooks()->list(['status' => 'active']);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listWebhooksRequest(
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            $filters['sort'] ?? null,
            $filters['direction'] ?? null,
            isset($filters['page']) ? (int) $filters['page'] : null,
            isset($filters['per_page']) ? (int) $filters['per_page'] : null,
        ));
    }

    /**
     * Retrieve a webhook by UUID.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @return Response The requested webhook.
     *
     * @throws ApiException When the webhook cannot be retrieved.
     *
     * @example
     * $webhook = $mm->webhooks()->get($webhookId);
     */
    public function get(string $webhookId): Response
    {
        return $this->executeRequest($this->api()->getWebhookRequest($webhookId));
    }

    /**
     * Update a webhook.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @param array{
     *     name?: string,
     *     url?: string,
     *     subscribed_events?: list<string>,
     *     is_active?: bool
     * } $parameters Attributes to update.
     * @return Response The updated webhook.
     *
     * @throws ApiException When the webhook cannot be updated.
     *
     * @example
     * $webhook = $mm->webhooks()->update($webhookId, [
     *     'subscribed_events' => ['email.delivered', 'email.bounced'],
     * ]);
     */
    public function update(string $webhookId, array $parameters): Response
    {
        $request = $parameters === []
            ? null
            : RequestBuilder::make(UpdateWebhookRequest::class, $parameters);

        return $this->executeRequest(
            $this->api()->updateWebhookRequest($webhookId, $request)
        );
    }

    /**
     * Delete a webhook.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @return Response Deletion confirmation.
     *
     * @throws ApiException When the webhook cannot be deleted.
     *
     * @example
     * $mm->webhooks()->delete($webhookId);
     */
    public function delete(string $webhookId): Response
    {
        return $this->executeRequest($this->api()->deleteWebhookRequest($webhookId));
    }

    /**
     * Queue a test delivery to the webhook endpoint.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @param  array{event_type?: string|null}  $parameters  Optional test event type.
     * @return Response The queued test delivery.
     *
     * @throws ApiException When the test cannot be queued.
     *
     * @example
     * $mm->webhooks()->test($webhookId, ['event_type' => 'email.delivered']);
     */
    public function test(string $webhookId, array $parameters = []): Response
    {
        $request = $parameters === []
            ? null
            : RequestBuilder::make(TestWebhookRequest::class, $parameters);

        return $this->executeRequest(
            $this->api()->testWebhookRequest($webhookId, $request)
        );
    }

    /**
     * Rotate the webhook signing secret.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @return Response The webhook including the new one-time signing secret.
     *
     * @throws ApiException When the secret cannot be rotated.
     *
     * @example
     * $rotated = $mm->webhooks()->rotateSecret($webhookId);
     * $secret = $rotated->data()['signing_secret'];
     */
    public function rotateSecret(string $webhookId): Response
    {
        return $this->executeRequest($this->api()->rotateWebhookSecretRequest($webhookId));
    }

    /**
     * Enable a webhook.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @return Response The enabled webhook.
     *
     * @throws ApiException When the webhook cannot be enabled.
     *
     * @example
     * $mm->webhooks()->enable($webhookId);
     */
    public function enable(string $webhookId): Response
    {
        return $this->executeRequest($this->api()->enableWebhookRequest($webhookId));
    }

    /**
     * Disable a webhook.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @return Response The disabled webhook.
     *
     * @throws ApiException When the webhook cannot be disabled.
     *
     * @example
     * $mm->webhooks()->disable($webhookId);
     */
    public function disable(string $webhookId): Response
    {
        return $this->executeRequest($this->api()->disableWebhookRequest($webhookId));
    }

    /**
     * List deliveries for a webhook.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @param array{
     *     status?: string,
     *     event_type?: string,
     *     search?: string,
     *     http_status?: int,
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     per_page?: int
     * } $filters Delivery filters.
     * @return Collection Webhook deliveries with pagination metadata when present.
     *
     * @throws ApiException When deliveries cannot be listed.
     *
     * @example
     * $deliveries = $mm->webhooks()->deliveries($webhookId, ['status' => 'failed']);
     */
    public function deliveries(string $webhookId, array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listWebhookDeliveriesRequest(
            $webhookId,
            $filters['status'] ?? null,
            $filters['event_type'] ?? null,
            $filters['search'] ?? null,
            isset($filters['http_status']) ? (int) $filters['http_status'] : null,
            $this->normalizeDate($filters['from'] ?? null, 'from'),
            $this->normalizeDate($filters['to'] ?? null, 'to'),
            isset($filters['per_page']) ? (int) $filters['per_page'] : null,
        ));
    }

    /**
     * Retrieve a webhook delivery by UUID.
     *
     * @param  string  $deliveryId  Webhook delivery UUID.
     * @return Response Delivery detail, including request/response logs.
     *
     * @throws ApiException When the delivery cannot be retrieved.
     *
     * @example
     * $delivery = $mm->webhooks()->delivery($deliveryId);
     */
    public function delivery(string $deliveryId): Response
    {
        return $this->executeRequest($this->api()->getWebhookDeliveryRequest($deliveryId));
    }

    /**
     * Retrieve delivery logs for a webhook.
     *
     * Alias of {@see deliveries()}.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @param  array<string, mixed>  $filters  Delivery filters.
     * @return Collection Delivery log entries.
     *
     * @throws ApiException When logs cannot be retrieved.
     *
     * @example
     * $logs = $mm->webhooks()->logs($webhookId);
     */
    public function logs(string $webhookId, array $filters = []): Collection
    {
        return $this->deliveries($webhookId, $filters);
    }

    /**
     * Retrieve failed deliveries for a webhook.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @param  array<string, mixed>  $filters  Additional delivery filters.
     * @return Collection Failed deliveries.
     *
     * @throws ApiException When failures cannot be retrieved.
     *
     * @example
     * $failures = $mm->webhooks()->failures($webhookId);
     */
    public function failures(string $webhookId, array $filters = []): Collection
    {
        return $this->deliveries($webhookId, ['status' => 'failed', ...$filters]);
    }

    /**
     * Replay webhook deliveries in bulk.
     *
     * @param  string  $webhookId  Webhook UUID.
     * @param array{
     *     failed_only?: bool,
     *     from?: string|DateTimeInterface|null,
     *     to?: string|DateTimeInterface|null,
     *     event_types?: list<string>,
     *     delivery_ids?: list<string>
     * } $parameters Replay options.
     * @return Response Replay result summary.
     *
     * @throws ApiException When deliveries cannot be replayed.
     *
     * @example
     * $mm->webhooks()->replay($webhookId, ['failed_only' => true]);
     */
    public function replay(string $webhookId, array $parameters = []): Response
    {
        $request = $parameters === []
            ? null
            : RequestBuilder::make(
                ReplayWebhookRequest::class,
                $this->normalizeReplayParameters($parameters),
            );

        return $this->executeRequest(
            $this->api()->replayWebhookDeliveriesRequest($webhookId, $request)
        );
    }

    /**
     * Retry a single webhook delivery.
     *
     * @param  string  $deliveryId  Webhook delivery UUID.
     * @return Response The retried delivery.
     *
     * @throws ApiException When the delivery cannot be retried.
     *
     * @example
     * $mm->webhooks()->retry($deliveryId);
     */
    public function retry(string $deliveryId): Response
    {
        return $this->executeRequest(
            $this->api()->replayWebhookDeliveryRequest($deliveryId)
        );
    }

    /**
     * Verify a webhook signature locally.
     *
     * MailerMine signs payloads with HMAC-SHA256 using the webhook signing
     * secret. Accepts either the raw hex digest or a `sha256=` prefixed value.
     *
     * @param  string  $payload  Raw request body.
     * @param  string  $signature  Signature header value.
     * @param  string  $secret  Webhook signing secret.
     * @return bool True when the signature is valid.
     *
     * @example
     * $valid = Webhooks::verify($rawBody, $_SERVER['HTTP_X_MAILERMINE_SIGNATURE'], $secret);
     */
    public static function verify(string $payload, string $signature, string $secret): bool
    {
        $expected = hash_hmac('sha256', $payload, $secret);
        $normalized = str_starts_with(strtolower($signature), 'sha256=')
            ? substr($signature, 7)
            : $signature;

        return hash_equals($expected, $normalized);
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function normalizeReplayParameters(array $parameters): array
    {
        if (array_key_exists('from', $parameters)) {
            $parameters['from'] = $this->normalizeDateTime($parameters['from'], 'from');
        }

        if (array_key_exists('to', $parameters)) {
            $parameters['to'] = $this->normalizeDateTime($parameters['to'], 'to');
        }

        return $parameters;
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
            sprintf('The %s field must be an ISO-8601 string or DateTimeInterface.', $field)
        );
    }

    private function normalizeDateTime(mixed $value, string $field): ?DateTime
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof DateTime) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return DateTime::createFromInterface($value);
        }

        if (is_string($value)) {
            try {
                return new DateTime($value);
            } catch (Exception $exception) {
                throw new InvalidArgumentException(
                    sprintf('The %s field must be a valid ISO-8601 datetime string.', $field),
                    previous: $exception,
                );
            }
        }

        throw new InvalidArgumentException(
            sprintf('The %s field must be an ISO-8601 string or DateTimeInterface.', $field)
        );
    }

    private function api(): WebhooksApi
    {
        return $this->api ??= new WebhooksApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
