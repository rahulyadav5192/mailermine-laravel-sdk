<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\SegmentsApi;
use OpenAPI\Client\Model\CreateSegmentRequest;
use OpenAPI\Client\Model\PreviewSegmentRequest;
use OpenAPI\Client\Model\UpdateSegmentRequest;

/**
 * Segments resource.
 *
 * Wraps {@see SegmentsApi}.
 */
final class Segments extends BaseResource
{
    private ?SegmentsApi $api = null;

    /**
     * Create a dynamic segment.
     *
     * @param array{
     *     name: string,
     *     description?: string|null,
     *     rules: array<string, mixed>
     * } $parameters Segment attributes. `rules` must include `logic` and nested rules.
     * @return Response The created segment.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $segment = $mm->segments()->create([
     *     'name' => 'Active subscribers',
     *     'rules' => [
     *         'logic' => 'and',
     *         'rules' => [
     *             ['field' => 'subscribed', 'operator' => 'equals', 'value' => true],
     *         ],
     *     ],
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateSegmentRequest::class, $parameters);

        return $this->executeRequest($this->api()->createSegmentRequest($request));
    }

    /**
     * List segments with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Segment list filters.
     * @return Collection A collection of segments with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $segments = $mm->segments()->list(['search' => 'active']);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listSegmentsRequest(
            $filters['search'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve a segment by UUID.
     *
     * @param  string  $segmentId  Segment UUID.
     * @return Response The requested segment.
     *
     * @throws ApiException When the segment cannot be retrieved.
     *
     * @example
     * $segment = $mm->segments()->get($segmentId);
     */
    public function get(string $segmentId): Response
    {
        return $this->executeRequest($this->api()->getSegmentRequest($segmentId));
    }

    /**
     * Update a segment.
     *
     * @param  string  $segmentId  Segment UUID.
     * @param array{
     *     name?: string,
     *     description?: string|null,
     *     rules?: array<string, mixed>
     * } $parameters Attributes to update.
     * @return Response The updated segment.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $segment = $mm->segments()->update($segmentId, [
     *     'name' => 'Engaged subscribers',
     * ]);
     */
    public function update(string $segmentId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateSegmentRequest::class, $parameters);

        return $this->executeRequest($this->api()->updateSegmentRequest($segmentId, $request));
    }

    /**
     * Delete a segment.
     *
     * @param  string  $segmentId  Segment UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the segment cannot be deleted.
     *
     * @example
     * $mm->segments()->delete($segmentId);
     */
    public function delete(string $segmentId): Response
    {
        return $this->executeRequest($this->api()->deleteSegmentRequest($segmentId));
    }

    /**
     * Preview a saved segment or unsaved segment rules.
     *
     * When `$segmentId` is provided, the saved segment is previewed. When
     * `$rules` is provided without an ID, unsaved rules are previewed.
     *
     * @param  string|null  $segmentId  Saved segment UUID.
     * @param  array<string, mixed>|null  $rules  Unsaved segment rules.
     * @return Response Preview count and sample contacts.
     *
     * @throws ApiException When the segment cannot be previewed.
     *
     * @example
     * $preview = $mm->segments()->preview($segmentId);
     * $preview = $mm->segments()->preview(null, [
     *     'logic' => 'and',
     *     'rules' => [
     *         ['field' => 'subscribed', 'operator' => 'equals', 'value' => true],
     *     ],
     * ]);
     */
    public function preview(?string $segmentId = null, ?array $rules = null): Response
    {
        if ($segmentId !== null && $segmentId !== '') {
            return $this->executeRequest($this->api()->previewSegmentRequest($segmentId));
        }

        if ($rules === null) {
            throw new InvalidArgumentException(
                'Provide a segment id or rules array when calling preview().'
            );
        }

        $request = RequestBuilder::make(PreviewSegmentRequest::class, [
            'rules' => $rules,
        ]);

        return $this->executeRequest($this->api()->previewSegmentRulesRequest($request));
    }

    private function api(): SegmentsApi
    {
        return $this->api ??= new SegmentsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
