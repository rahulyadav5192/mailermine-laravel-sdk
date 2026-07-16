<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\ListsApi;
use OpenAPI\Client\Model\CreateListRequest;
use OpenAPI\Client\Model\ListContactsMembershipRequest;
use OpenAPI\Client\Model\UpdateListRequest;

/**
 * Lists resource.
 *
 * Wraps {@see ListsApi}.
 */
final class Lists extends BaseResource
{
    private ?ListsApi $api = null;

    /**
     * Create a static contact list.
     *
     * @param array{
     *     name: string,
     *     description?: string|null,
     *     color?: string|null
     * } $parameters List attributes.
     * @return Response The created list.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $list = $mm->lists()->create([
     *     'name' => 'Newsletter',
     *     'description' => 'Weekly product updates',
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateListRequest::class, $parameters);

        return $this->executeRequest($this->api()->createListRequest($request));
    }

    /**
     * List contact lists with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters List filters.
     * @return Collection A collection of lists with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $lists = $mm->lists()->list(['search' => 'newsletter']);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listListsRequest(
            $filters['search'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve a list by UUID.
     *
     * @param  string  $listId  List UUID.
     * @return Response The requested list.
     *
     * @throws ApiException When the list cannot be retrieved.
     *
     * @example
     * $list = $mm->lists()->get($listId);
     */
    public function get(string $listId): Response
    {
        return $this->executeRequest($this->api()->getListRequest($listId));
    }

    /**
     * Update a list.
     *
     * @param  string  $listId  List UUID.
     * @param array{
     *     name?: string,
     *     description?: string|null,
     *     color?: string|null
     * } $parameters Attributes to update.
     * @return Response The updated list.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $list = $mm->lists()->update($listId, ['name' => 'Product Updates']);
     */
    public function update(string $listId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateListRequest::class, $parameters);

        return $this->executeRequest($this->api()->updateListRequest($listId, $request));
    }

    /**
     * Delete a list.
     *
     * @param  string  $listId  List UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the list cannot be deleted.
     *
     * @example
     * $mm->lists()->delete($listId);
     */
    public function delete(string $listId): Response
    {
        return $this->executeRequest($this->api()->deleteListRequest($listId));
    }

    /**
     * Add one or more contacts to a list.
     *
     * @param  string  $listId  List UUID.
     * @param  string|list<string>  $contactIds  Contact UUID or list of UUIDs.
     * @return Response Membership result containing the number of contacts added.
     *
     * @throws ApiException When membership cannot be updated.
     *
     * @example
     * $mm->lists()->addContact($listId, $contactId);
     * $mm->lists()->addContact($listId, [$contactIdA, $contactIdB]);
     */
    public function addContact(string $listId, string|array $contactIds): Response
    {
        $request = RequestBuilder::make(ListContactsMembershipRequest::class, [
            'ids' => $this->normalizeIds($contactIds),
        ]);

        return $this->executeRequest($this->api()->addContactsToListRequest($listId, $request));
    }

    /**
     * Remove one or more contacts from a list.
     *
     * @param  string  $listId  List UUID.
     * @param  string|list<string>  $contactIds  Contact UUID or list of UUIDs.
     * @return Response Membership result containing the number of contacts removed.
     *
     * @throws ApiException When membership cannot be updated.
     *
     * @example
     * $mm->lists()->removeContact($listId, $contactId);
     */
    public function removeContact(string $listId, string|array $contactIds): Response
    {
        $request = RequestBuilder::make(ListContactsMembershipRequest::class, [
            'ids' => $this->normalizeIds($contactIds),
        ]);

        return $this->executeRequest(
            $this->api()->bulkRemoveContactsFromListRequest($listId, $request)
        );
    }

    /**
     * @param  string|list<string>  $contactIds
     * @return list<string>
     */
    private function normalizeIds(string|array $contactIds): array
    {
        $ids = is_string($contactIds) ? [$contactIds] : array_values($contactIds);

        if ($ids === []) {
            throw new InvalidArgumentException('At least one contact id is required.');
        }

        return $ids;
    }

    private function api(): ListsApi
    {
        return $this->api ??= new ListsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
