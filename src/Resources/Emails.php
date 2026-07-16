<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTimeInterface;
use InvalidArgumentException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\EmailsApi;
use OpenAPI\Client\Api\MessagesApi;
use OpenAPI\Client\Model\SendEmailRequest;
use OpenAPI\Client\Model\SendEmailRequestAttachmentsInner;

/**
 * Emails resource.
 *
 * Provides a cohesive email API over the generated send and message clients.
 *
 * @example
 *  $mm->emails()->send([
 *      'from' => 'hello@example.com',
 *      'to' => ['user@example.com'],
 *      'subject' => 'Hello',
 *      'html' => '<p>Hi</p>',
 *  ]);
 */
final class Emails extends BaseResource
{
    private ?EmailsApi $emailsApi = null;

    private ?MessagesApi $messagesApi = null;

    /**
     * Queue a transactional or template email for delivery.
     *
     * A single string or an array of strings is accepted for `to`, `cc`, and
     * `bcc`. Attachment content must be Base64 encoded.
     *
     * @param array{
     *     from: string,
     *     to: string|list<string>,
     *     cc?: string|list<string>,
     *     bcc?: string|list<string>,
     *     template_id?: string,
     *     variables?: array<string, mixed>,
     *     subject?: string,
     *     html?: string,
     *     text?: string,
     *     reply_to?: string,
     *     metadata?: array<string, mixed>,
     *     tags?: list<string>,
     *     headers?: array<string, string>,
     *     attachments?: list<array{filename: string, content: string, content_type?: string|null}>
     * } $parameters Email fields supported by the MailerMine API.
     * @return Response A clean SDK response containing the queued message.
     *
     * @example
     * $email = $mm->emails()->send([
     *     'from' => 'MailerMine <hello@mailermine.com>',
     *     'to' => 'john@example.com',
     *     'subject' => 'Hello',
     *     'html' => '<h1>Hello</h1>',
     * ]);
     *
     * echo $email->data()['uuid'];
     */
    public function send(array $parameters): Response
    {
        $request = RequestBuilder::make(
            SendEmailRequest::class,
            $this->normalizeSendParameters($parameters),
        );

        return $this->executeRequest(
            $this->emailsApi()->sendEmailRequest($request)
        );
    }

    /**
     * List sent and queued emails with optional filters and pagination.
     *
     * Supported filters are `search`, `status`, `provider`, `from`, `to`,
     * `page`, and `per_page`. Dates may be ISO-8601 strings or DateTime objects.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     provider?: string,
     *     from?: string|DateTimeInterface,
     *     to?: string|DateTimeInterface,
     *     page?: int,
     *     per_page?: int
     * } $filters Filters accepted by the message history endpoint.
     * @return Collection A collection of clean message arrays with pagination.
     *
     * @example
     * $emails = $mm->emails()->list([
     *     'status' => 'sent',
     *     'page' => 1,
     *     'per_page' => 25,
     * ]);
     *
     * foreach ($emails as $email) {
     *     echo $email['subject'];
     * }
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->messagesApi()->listMessagesRequest(
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
     * Retrieve one sent or queued email by message UUID.
     *
     * @param  string  $messageId  MailerMine message UUID.
     * @return Response A clean SDK response containing the message details.
     *
     * @example
     * $email = $mm->emails()->get('550e8400-e29b-41d4-a716-446655440000');
     *
     * echo $email->data()['status'];
     */
    public function get(string $messageId): Response
    {
        return $this->executeRequest(
            $this->messagesApi()->getMessageRequest($messageId)
        );
    }

    /**
     * Retrieve lifecycle events for an email.
     *
     * Events include delivery and engagement activity such as delivered,
     * opened, clicked, bounced, or complained.
     *
     * @param  string  $messageId  MailerMine message UUID.
     * @return Collection A collection of clean event arrays.
     *
     * @example
     * $events = $mm->emails()->events('550e8400-e29b-41d4-a716-446655440000');
     *
     * foreach ($events as $event) {
     *     echo $event['event_type'];
     * }
     */
    public function events(string $messageId): Collection
    {
        return $this->executeCollectionRequest(
            $this->messagesApi()->messageEventsRequest($messageId)
        );
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function normalizeSendParameters(array $parameters): array
    {
        foreach (['to', 'cc', 'bcc'] as $field) {
            if (isset($parameters[$field]) && is_string($parameters[$field])) {
                $parameters[$field] = [$parameters[$field]];
            }
        }

        if (isset($parameters['attachments'])) {
            if (!is_array($parameters['attachments'])) {
                throw new InvalidArgumentException('The attachments field must be an array.');
            }

            $parameters['attachments'] = array_map(
                static function (mixed $attachment): SendEmailRequestAttachmentsInner {
                    if (!is_array($attachment)) {
                        throw new InvalidArgumentException('Each attachment must be an array.');
                    }

                    return RequestBuilder::make(
                        SendEmailRequestAttachmentsInner::class,
                        $attachment,
                    );
                },
                $parameters['attachments'],
            );
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
            sprintf('The %s filter must be an ISO-8601 string or DateTimeInterface.', $field)
        );
    }

    private function emailsApi(): EmailsApi
    {
        return $this->emailsApi ??= new EmailsApi(
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
