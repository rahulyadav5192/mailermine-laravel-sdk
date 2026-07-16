<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\ProjectsApi;
use OpenAPI\Client\Model\CreateProjectRequest;
use OpenAPI\Client\Model\UpdateProjectRequest;

/**
 * Projects resource.
 *
 * Wraps {@see ProjectsApi}.
 */
final class Projects extends BaseResource
{
    private ?ProjectsApi $api = null;

    /**
     * Create a MailerMine project.
     *
     * @param array{
     *     name: string,
     *     slug?: string,
     *     description?: string,
     *     environment?: string,
     *     timezone?: string,
     *     default_sender?: string,
     *     settings?: array<string, mixed>
     * } $parameters Project attributes.
     * @return Response The created project.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $project = $mm->projects()->create([
     *     'name' => 'Production Mail',
     *     'environment' => 'production',
     *     'timezone' => 'UTC',
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateProjectRequest::class, $parameters);

        return $this->executeRequest($this->api()->createProjectRequest($request));
    }

    /**
     * List projects with optional filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Project list filters.
     * @return Collection A collection of projects with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $projects = $mm->projects()->list([
     *     'status' => 'active',
     *     'page' => 1,
     * ]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listProjectsRequest(
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve a project by UUID.
     *
     * @param  string  $projectId  Project UUID.
     * @return Response The requested project.
     *
     * @throws ApiException When the project cannot be retrieved.
     *
     * @example
     * $project = $mm->projects()->get('550e8400-e29b-41d4-a716-446655440000');
     */
    public function get(string $projectId): Response
    {
        return $this->executeRequest($this->api()->getProjectRequest($projectId));
    }

    /**
     * Update a project.
     *
     * @param  string  $projectId  Project UUID.
     * @param array{
     *     name?: string,
     *     slug?: string,
     *     description?: string,
     *     environment?: string,
     *     timezone?: string,
     *     default_sender?: string,
     *     settings?: array<string, mixed>,
     *     status?: string
     * } $parameters Attributes to update.
     * @return Response The updated project.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $project = $mm->projects()->update($projectId, [
     *     'name' => 'Production Email',
     * ]);
     */
    public function update(string $projectId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateProjectRequest::class, $parameters);

        return $this->executeRequest($this->api()->updateProjectRequest($projectId, $request));
    }

    /**
     * Delete a project.
     *
     * @param  string  $projectId  Project UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the project cannot be deleted.
     *
     * @example
     * $mm->projects()->delete('550e8400-e29b-41d4-a716-446655440000');
     */
    public function delete(string $projectId): Response
    {
        return $this->executeRequest($this->api()->deleteProjectRequest($projectId));
    }

    private function api(): ProjectsApi
    {
        return $this->api ??= new ProjectsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
