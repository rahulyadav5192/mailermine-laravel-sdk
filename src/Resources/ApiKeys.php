<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTimeInterface;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\APIKeysApi;
use OpenAPI\Client\Model\CreateApiKeyRequest;
use OpenAPI\Client\Model\UpdateApiKeyRequest;

/**
 * API Keys resource.
 *
 * Wraps {@see APIKeysApi}.
 */
final class ApiKeys extends BaseResource
{
    private ?APIKeysApi $api = null;

    /**
     * Create an API key for a project.
     *
     * The plaintext secret is returned only when the key is created or rotated.
     *
     * @param  string  $projectId  Project UUID.
     * @param array{
     *     name: string,
     *     expires_at?: string|DateTimeInterface|null,
     *     scopes?: list<string>,
     *     permissions?: list<string>
     * } $parameters API key attributes.
     * @return Response The created key, including its one-time plaintext secret.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $key = $mm->apiKeys()->create($projectId, [
     *     'name' => 'Production',
     *     'scopes' => ['emails.send'],
     * ]);
     *
     * $secret = $key->data()['secret'];
     */
    public function create(string $projectId, array $parameters): Response
    {
        $request = RequestBuilder::make(CreateApiKeyRequest::class, $parameters);

        return $this->executeRequest($this->api()->createApiKeyRequest($projectId, $request));
    }

    /**
     * List API keys for a project.
     *
     * List responses contain key metadata but never plaintext secrets.
     *
     * @param  string  $projectId  Project UUID.
     * @param array{
     *     search?: string,
     *     status?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters API key list filters.
     * @return Collection A collection of API keys with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $keys = $mm->apiKeys()->list($projectId, [
     *     'status' => 'active',
     * ]);
     */
    public function list(string $projectId, array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listApiKeysRequest(
            $projectId,
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve API key metadata.
     *
     * @param  string  $projectId  Project UUID.
     * @param  string  $apiKeyId  API key UUID.
     * @return Response The requested API key metadata.
     *
     * @throws ApiException When the key cannot be retrieved.
     *
     * @example
     * $key = $mm->apiKeys()->get($projectId, $apiKeyId);
     */
    public function get(string $projectId, string $apiKeyId): Response
    {
        return $this->executeRequest($this->api()->getApiKeyRequest($projectId, $apiKeyId));
    }

    /**
     * Update API key metadata, status, scopes, or permissions.
     *
     * @param  string  $projectId  Project UUID.
     * @param  string  $apiKeyId  API key UUID.
     * @param array{
     *     name?: string,
     *     expires_at?: string|DateTimeInterface|null,
     *     status?: string,
     *     scopes?: list<string>,
     *     permissions?: list<string>
     * } $parameters Attributes to update.
     * @return Response The updated API key metadata.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $key = $mm->apiKeys()->update($projectId, $apiKeyId, [
     *     'name' => 'Production sender',
     * ]);
     */
    public function update(string $projectId, string $apiKeyId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateApiKeyRequest::class, $parameters);

        return $this->executeRequest(
            $this->api()->updateApiKeyRequest($projectId, $apiKeyId, $request)
        );
    }

    /**
     * Delete an API key.
     *
     * @param  string  $projectId  Project UUID.
     * @param  string  $apiKeyId  API key UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the key cannot be deleted.
     *
     * @example
     * $mm->apiKeys()->delete($projectId, $apiKeyId);
     */
    public function delete(string $projectId, string $apiKeyId): Response
    {
        return $this->executeRequest($this->api()->deleteApiKeyRequest($projectId, $apiKeyId));
    }

    /**
     * Rotate an API key and return its new one-time plaintext secret.
     *
     * @param  string  $projectId  Project UUID.
     * @param  string  $apiKeyId  API key UUID.
     * @return Response The rotated key and its new plaintext secret.
     *
     * @throws ApiException When the key cannot be rotated.
     *
     * @example
     * $rotated = $mm->apiKeys()->rotate($projectId, $apiKeyId);
     * $newSecret = $rotated->data()['secret'];
     */
    public function rotate(string $projectId, string $apiKeyId): Response
    {
        return $this->executeRequest($this->api()->rotateApiKeyRequest($projectId, $apiKeyId));
    }

    /**
     * Request revelation of an API key secret.
     *
     * MailerMine irreversibly hashes secrets, so the current API normally
     * rejects this operation with a ValidationException. Use rotate() to issue
     * a new secret.
     *
     * @param  string  $projectId  Project UUID.
     * @param  string  $apiKeyId  API key UUID.
     * @return Response The API response if revelation is supported by the server.
     *
     * @throws ApiException When the secret cannot be revealed.
     *
     * @example
     * $key = $mm->apiKeys()->reveal($projectId, $apiKeyId);
     */
    public function reveal(string $projectId, string $apiKeyId): Response
    {
        return $this->executeRequest($this->api()->revealApiKeyRequest($projectId, $apiKeyId));
    }

    private function api(): APIKeysApi
    {
        return $this->api ??= new APIKeysApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
