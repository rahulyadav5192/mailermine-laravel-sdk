<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\AudiencesApi;
use OpenAPI\Client\Model\ListContactsMembershipRequest;

/**
 * Audiences resource.
 *
 * Audiences are a unified catalog of static lists and dynamic segments.
 * Creation, updates, and deletion are delegated to Lists or Segments based on
 * the audience `source`.
 *
 * Wraps {@see AudiencesApi}.
 */
final class Audiences extends BaseResource
{
    private ?AudiencesApi $api = null;

    /**
     * Create an audience-backed list or segment.
     *
     * Pass `source` as `list` (default) or `segment`. Remaining fields are
     * forwarded to the corresponding resource.
     *
     * @param array{
     *     source?: 'list'|'segment',
     *     name: string,
     *     description?: string|null,
     *     color?: string|null,
     *     rules?: array<string, mixed>
     * } $parameters Audience attributes.
     * @return Response The created list or segment.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $audience = $mm->audiences()->create([
     *     'source' => 'list',
     *     'name' => 'VIP Customers',
     * ]);
     */
    public function create(array $parameters): Response
    {
        $source = $this->normalizeSource($parameters['source'] ?? 'list');
        unset($parameters['source']);

        return match ($source) {
            'list' => $this->client->lists()->create($parameters),
            'segment' => $this->client->segments()->create([
                ...$parameters,
                'rules' => $parameters['rules'] ?? [],
            ]),
        };
    }

    /**
     * List audiences with pagination.
     *
     * @param  array{page?: int, per_page?: int}  $filters  Audience list filters.
     * @return Collection A collection of audiences with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $audiences = $mm->audiences()->list(['page' => 1]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listAudiencesRequest(
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve an audience by source and UUID.
     *
     * @param  string  $source  Audience source (`list` or `segment`).
     * @param  string  $audienceId  List or segment UUID.
     * @return Response The requested audience.
     *
     * @throws ApiException When the audience cannot be retrieved.
     *
     * @example
     * $audience = $mm->audiences()->get('list', $listId);
     */
    public function get(string $source, string $audienceId): Response
    {
        return $this->executeRequest(
            $this->api()->getAudienceRequest($this->normalizeSource($source), $audienceId)
        );
    }

    /**
     * Update an audience-backed list or segment.
     *
     * @param  string  $source  Audience source (`list` or `segment`).
     * @param  string  $audienceId  List or segment UUID.
     * @param  array<string, mixed>  $parameters  Attributes to update.
     * @return Response The updated list or segment.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $audience = $mm->audiences()->update('list', $listId, [
     *     'name' => 'VIP Customers',
     * ]);
     */
    public function update(string $source, string $audienceId, array $parameters): Response
    {
        return match ($this->normalizeSource($source)) {
            'list' => $this->client->lists()->update($audienceId, $parameters),
            'segment' => $this->client->segments()->update($audienceId, $parameters),
        };
    }

    /**
     * Delete an audience-backed list or segment.
     *
     * @param  string  $source  Audience source (`list` or `segment`).
     * @param  string  $audienceId  List or segment UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the audience cannot be deleted.
     *
     * @example
     * $mm->audiences()->delete('list', $listId);
     */
    public function delete(string $source, string $audienceId): Response
    {
        return match ($this->normalizeSource($source)) {
            'list' => $this->client->lists()->delete($audienceId),
            'segment' => $this->client->segments()->delete($audienceId),
        };
    }

    /**
     * List contacts belonging to an audience.
     *
     * @param  string  $source  Audience source (`list` or `segment`).
     * @param  string  $audienceId  List or segment UUID.
     * @param  array<string, mixed>  $filters  Additional contact filters.
     * @return Collection Contacts in the audience with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $contacts = $mm->audiences()->contacts('list', $listId);
     */
    public function contacts(string $source, string $audienceId, array $filters = []): Collection
    {
        $source = $this->normalizeSource($source);
        $key = $source === 'segment' ? 'segment' : 'list';

        return $this->client->contacts()->list([...$filters, $key => $audienceId]);
    }

    /**
     * Add contacts to a list-backed audience.
     *
     * @param  string  $audienceId  List UUID.
     * @param  string|list<string>  $contactIds  Contact UUID or list of UUIDs.
     * @return Response Membership result.
     *
     * @throws ApiException When membership cannot be updated.
     *
     * @example
     * $mm->audiences()->addContacts($listId, [$contactId]);
     */
    public function addContacts(string $audienceId, string|array $contactIds): Response
    {
        $ids = is_string($contactIds) ? [$contactIds] : array_values($contactIds);
        $request = RequestBuilder::make(ListContactsMembershipRequest::class, ['ids' => $ids]);

        return $this->executeRequest(
            $this->api()->addAudienceMembersRequest('list', $audienceId, $request)
        );
    }

    /**
     * Remove contacts from a list-backed audience.
     *
     * @param  string  $audienceId  List UUID.
     * @param  string|list<string>  $contactIds  Contact UUID or list of UUIDs.
     * @return Response Membership result.
     *
     * @throws ApiException When membership cannot be updated.
     *
     * @example
     * $mm->audiences()->removeContacts($listId, [$contactId]);
     */
    public function removeContacts(string $audienceId, string|array $contactIds): Response
    {
        $ids = is_string($contactIds) ? [$contactIds] : array_values($contactIds);

        return $this->executeRequest(
            $this->api()->removeAudienceMembersRequest('list', $audienceId, $ids)
        );
    }

    /**
     * @return 'list'|'segment'
     */
    private function normalizeSource(mixed $source): string
    {
        if (!is_string($source) || !in_array($source, ['list', 'segment'], true)) {
            throw new InvalidArgumentException('Audience source must be "list" or "segment".');
        }

        return $source;
    }

    private function api(): AudiencesApi
    {
        return $this->api ??= new AudiencesApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
