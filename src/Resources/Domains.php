<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\DomainsApi;
use OpenAPI\Client\Model\CreateDomainRequest;

/**
 * Domains resource.
 *
 * Wraps {@see DomainsApi}.
 */
final class Domains extends BaseResource
{
    private ?DomainsApi $api = null;

    /**
     * Add a sending domain.
     *
     * @param  array{domain: string}  $parameters  Domain attributes.
     * @return Response The created domain and DNS configuration.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $domain = $mm->domains()->create([
     *     'domain' => 'mail.example.com',
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateDomainRequest::class, $parameters);

        return $this->executeRequest($this->api()->createDomainRequest($request));
    }

    /**
     * List sending domains with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Domain list filters.
     * @return Collection A collection of domains with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $domains = $mm->domains()->list([
     *     'status' => 'verified',
     * ]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listDomainsRequest(
            $filters['search'] ?? null,
            $filters['status'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Retrieve a sending domain by UUID.
     *
     * @param  string  $domainId  Domain UUID.
     * @return Response The domain, DNS records, and verification status.
     *
     * @throws ApiException When the domain cannot be retrieved.
     *
     * @example
     * $domain = $mm->domains()->get('550e8400-e29b-41d4-a716-446655440000');
     */
    public function get(string $domainId): Response
    {
        return $this->executeRequest($this->api()->getDomainRequest($domainId));
    }

    /**
     * Delete a sending domain.
     *
     * @param  string  $domainId  Domain UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the domain cannot be deleted.
     *
     * @example
     * $mm->domains()->delete('550e8400-e29b-41d4-a716-446655440000');
     */
    public function delete(string $domainId): Response
    {
        return $this->executeRequest($this->api()->deleteDomainRequest($domainId));
    }

    /**
     * Check the domain's DNS records and refresh its verification state.
     *
     * @param  string  $domainId  Domain UUID.
     * @return Response The refreshed domain and verification details.
     *
     * @throws ApiException When verification cannot be completed.
     *
     * @example
     * $domain = $mm->domains()->verify($domainId);
     * $verified = $domain->data()['verified'];
     */
    public function verify(string $domainId): Response
    {
        return $this->executeRequest($this->api()->verifyDomainRequest($domainId));
    }

    /**
     * Retrieve the DNS records required by a domain.
     *
     * MailerMine exposes DNS records within the domain detail response rather
     * than through a separate endpoint.
     *
     * @param  string  $domainId  Domain UUID.
     * @return Collection A clean collection of DNS record arrays.
     *
     * @throws ApiException When the domain cannot be retrieved.
     *
     * @example
     * foreach ($mm->domains()->dnsRecords($domainId) as $record) {
     *     echo $record['record_type'] . ' ' . $record['record_value'];
     * }
     */
    public function dnsRecords(string $domainId): Collection
    {
        $records = $this->get($domainId)->data()['dns_records'] ?? [];

        return new Collection(is_array($records) ? array_values($records) : []);
    }

    /**
     * Retrieve the verification status summary for a domain.
     *
     * MailerMine exposes component statuses within the domain detail response
     * rather than through a separate endpoint.
     *
     * @param  string  $domainId  Domain UUID.
     * @return Response A clean response containing domain status fields.
     *
     * @throws ApiException When the domain cannot be retrieved.
     *
     * @example
     * $status = $mm->domains()->status($domainId);
     * echo $status->data()['verification_status'];
     */
    public function status(string $domainId): Response
    {
        $response = $this->get($domainId);
        $domain = $response->data();
        $domain = is_array($domain) ? $domain : [];

        return Response::from([
            'success' => $response->success(),
            'message' => $response->message(),
            'data' => array_intersect_key($domain, array_flip([
                'status',
                'verified',
                'verification_status',
                'dns_status',
                'dkim_status',
                'spf_status',
                'tracking_status',
                'verification_error',
                'verified_at',
                'last_checked_at',
            ])),
        ]);
    }

    private function api(): DomainsApi
    {
        return $this->api ??= new DomainsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
