<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\TagsApi;
use OpenAPI\Client\Model\BulkTagContactsRequest;
use OpenAPI\Client\Model\CreateTagRequest;
use OpenAPI\Client\Model\UpdateTagRequest;

/**
 * Tags resource.
 *
 * Wraps {@see TagsApi}.
 */
final class Tags extends BaseResource
{
    private ?TagsApi $api = null;

    /**
     * Create a tag.
     *
     * @param array{
     *     name: string,
     *     color?: string|null
     * } $parameters Tag attributes.
     * @return Response The created tag.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $tag = $mm->tags()->create([
     *     'name' => 'vip',
     *     'color' => '#111827',
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateTagRequest::class, $parameters);

        return $this->executeRequest($this->api()->createTagRequest($request));
    }

    /**
     * List tags with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Tag list filters.
     * @return Collection A collection of tags with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $tags = $mm->tags()->list(['search' => 'vip']);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listTagsRequest(
            $filters['search'] ?? null,
            $filters['sort'] ?? 'name',
            $filters['direction'] ?? 'asc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve a tag by UUID.
     *
     * @param  string  $tagId  Tag UUID.
     * @return Response The requested tag.
     *
     * @throws ApiException When the tag cannot be retrieved.
     *
     * @example
     * $tag = $mm->tags()->get($tagId);
     */
    public function get(string $tagId): Response
    {
        return $this->executeRequest($this->api()->getTagRequest($tagId));
    }

    /**
     * Update a tag.
     *
     * @param  string  $tagId  Tag UUID.
     * @param array{
     *     name?: string,
     *     color?: string|null
     * } $parameters Attributes to update.
     * @return Response The updated tag.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $tag = $mm->tags()->update($tagId, ['name' => 'priority']);
     */
    public function update(string $tagId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateTagRequest::class, $parameters);

        return $this->executeRequest($this->api()->updateTagRequest($tagId, $request));
    }

    /**
     * Delete a tag.
     *
     * @param  string  $tagId  Tag UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the tag cannot be deleted.
     *
     * @example
     * $mm->tags()->delete($tagId);
     */
    public function delete(string $tagId): Response
    {
        return $this->executeRequest($this->api()->deleteTagRequest($tagId));
    }

    /**
     * Assign one or more tags to one or more contacts.
     *
     * @param array{
     *     contact_ids: string|list<string>,
     *     tag_ids: string|list<string>
     * } $parameters Assignment payload.
     * @return Response Assignment result containing the number of tags assigned.
     *
     * @throws ApiException When tags cannot be assigned.
     *
     * @example
     * $mm->tags()->assign([
     *     'contact_ids' => [$contactId],
     *     'tag_ids' => [$tagId],
     * ]);
     */
    public function assign(array $parameters): Response
    {
        $request = RequestBuilder::make(BulkTagContactsRequest::class, [
            'contact_ids' => $this->normalizeIds($parameters['contact_ids'] ?? null, 'contact_ids'),
            'tag_ids' => $this->normalizeIds($parameters['tag_ids'] ?? null, 'tag_ids'),
        ]);

        return $this->executeRequest($this->api()->bulkAssignTagsRequest($request));
    }

    /**
     * Remove one or more tags from one or more contacts.
     *
     * @param array{
     *     contact_ids: string|list<string>,
     *     tag_ids: string|list<string>
     * } $parameters Removal payload.
     * @return Response Removal result containing the number of tags removed.
     *
     * @throws ApiException When tags cannot be removed.
     *
     * @example
     * $mm->tags()->remove([
     *     'contact_ids' => [$contactId],
     *     'tag_ids' => [$tagId],
     * ]);
     */
    public function remove(array $parameters): Response
    {
        $request = RequestBuilder::make(BulkTagContactsRequest::class, [
            'contact_ids' => $this->normalizeIds($parameters['contact_ids'] ?? null, 'contact_ids'),
            'tag_ids' => $this->normalizeIds($parameters['tag_ids'] ?? null, 'tag_ids'),
        ]);

        return $this->executeRequest($this->api()->bulkRemoveTagsRequest($request));
    }

    /**
     * @return list<string>
     */
    private function normalizeIds(mixed $value, string $field): array
    {
        if (is_string($value)) {
            $value = [$value];
        }

        if (!is_array($value) || $value === []) {
            throw new InvalidArgumentException(sprintf('The %s field must contain at least one id.', $field));
        }

        return array_values($value);
    }

    private function api(): TagsApi
    {
        return $this->api ??= new TagsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
