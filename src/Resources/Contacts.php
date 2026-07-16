<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use DateTimeInterface;
use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\NotFoundException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\ContactsApi;
use OpenAPI\Client\Model\CreateContactRequest;
use OpenAPI\Client\Model\UpdateContactRequest;

/**
 * Contacts resource.
 *
 * Wraps {@see ContactsApi}.
 */
final class Contacts extends BaseResource
{
    private ?ContactsApi $api = null;

    /**
     * Create a contact.
     *
     * @param array{
     *     email: string,
     *     first_name?: string|null,
     *     last_name?: string|null,
     *     status?: string,
     *     subscribed?: bool,
     *     source?: string,
     *     metadata?: array<string, mixed>,
     *     list_ids?: list<string>,
     *     tag_ids?: list<string>,
     *     tag_names?: list<string>,
     *     custom_fields?: array<string, mixed>
     * } $parameters Contact attributes.
     * @return Response The created contact.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $contact = $mm->contacts()->create([
     *     'email' => 'john@example.com',
     *     'first_name' => 'John',
     *     'subscribed' => true,
     * ]);
     */
    public function create(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateContactRequest::class, $parameters);

        return $this->executeRequest($this->api()->createContactRequest($request));
    }

    /**
     * List contacts with filters and pagination.
     *
     * @param array{
     *     search?: string,
     *     q?: string,
     *     status?: string,
     *     subscribed?: bool|string|int,
     *     list?: string,
     *     tag?: string,
     *     tag_name?: string,
     *     source?: string,
     *     created_from?: string|DateTimeInterface,
     *     created_to?: string|DateTimeInterface,
     *     updated_from?: string|DateTimeInterface,
     *     updated_to?: string|DateTimeInterface,
     *     segment?: string,
     *     sort?: string,
     *     direction?: string,
     *     page?: int,
     *     per_page?: int
     * } $filters Contact list filters.
     * @return Collection A collection of contacts with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $contacts = $mm->contacts()->list([
     *     'subscribed' => true,
     *     'page' => 1,
     * ]);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listContactsRequest(
            $filters['search'] ?? null,
            $filters['q'] ?? null,
            $filters['status'] ?? null,
            isset($filters['subscribed']) ? filter_var($filters['subscribed'], FILTER_VALIDATE_BOOLEAN) : null,
            $filters['list'] ?? null,
            $filters['tag'] ?? null,
            $filters['tag_name'] ?? null,
            $filters['source'] ?? null,
            $this->normalizeDate($filters['created_from'] ?? null, 'created_from'),
            $this->normalizeDate($filters['created_to'] ?? null, 'created_to'),
            $this->normalizeDate($filters['updated_from'] ?? null, 'updated_from'),
            $this->normalizeDate($filters['updated_to'] ?? null, 'updated_to'),
            $filters['segment'] ?? null,
            $filters['sort'] ?? 'created_at',
            $filters['direction'] ?? 'desc',
            isset($filters['page']) ? (int) $filters['page'] : 1,
            isset($filters['per_page']) ? (int) $filters['per_page'] : 25,
        ));
    }

    /**
     * Search contacts by free-text query.
     *
     * @param  string  $query  Search text across email and name fields.
     * @param  array<string, mixed>  $filters  Additional list filters.
     * @return Collection Matching contacts with pagination.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $contacts = $mm->contacts()->search('john@example.com');
     */
    public function search(string $query, array $filters = []): Collection
    {
        return $this->list([...$filters, 'search' => $query]);
    }

    /**
     * Retrieve a contact by UUID.
     *
     * @param  string  $contactId  Contact UUID.
     * @return Response The requested contact.
     *
     * @throws ApiException When the contact cannot be retrieved.
     *
     * @example
     * $contact = $mm->contacts()->get($contactId);
     */
    public function get(string $contactId): Response
    {
        return $this->executeRequest($this->api()->getContactRequest($contactId));
    }

    /**
     * Update a contact.
     *
     * @param  string  $contactId  Contact UUID.
     * @param array{
     *     email?: string,
     *     first_name?: string|null,
     *     last_name?: string|null,
     *     status?: string,
     *     subscribed?: bool,
     *     metadata?: array<string, mixed>,
     *     list_ids?: list<string>,
     *     tag_ids?: list<string>,
     *     tag_names?: list<string>,
     *     custom_fields?: array<string, mixed>
     * } $parameters Attributes to update.
     * @return Response The updated contact.
     *
     * @throws ApiException When the API rejects the update.
     *
     * @example
     * $contact = $mm->contacts()->update($contactId, [
     *     'first_name' => 'Jonathan',
     * ]);
     */
    public function update(string $contactId, array $parameters): Response
    {
        $request = RequestBuilder::make(UpdateContactRequest::class, $parameters);

        return $this->executeRequest($this->api()->updateContactRequest($contactId, $request));
    }

    /**
     * Soft-delete a contact.
     *
     * @param  string  $contactId  Contact UUID.
     * @return Response The API deletion confirmation.
     *
     * @throws ApiException When the contact cannot be deleted.
     *
     * @example
     * $mm->contacts()->delete($contactId);
     */
    public function delete(string $contactId): Response
    {
        return $this->executeRequest($this->api()->deleteContactRequest($contactId));
    }

    /**
     * Identify an existing contact by email address.
     *
     * @param  string  $email  Contact email address.
     * @return Response The matching contact.
     *
     * @throws NotFoundException When no contact matches the email.
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $contact = $mm->contacts()->identify('john@example.com');
     */
    public function identify(string $email): Response
    {
        $contact = $this->findByEmail($email);

        if ($contact === null) {
            throw new NotFoundException(
                message: sprintf('No contact found for email [%s].', $email),
                statusCode: 404,
            );
        }

        return Response::from([
            'success' => true,
            'message' => 'Contact identified.',
            'data' => $contact,
        ]);
    }

    /**
     * Create a contact or update the existing contact with the same email.
     *
     * @param array{
     *     email: string,
     *     first_name?: string|null,
     *     last_name?: string|null,
     *     status?: string,
     *     subscribed?: bool,
     *     source?: string,
     *     metadata?: array<string, mixed>,
     *     list_ids?: list<string>,
     *     tag_ids?: list<string>,
     *     tag_names?: list<string>,
     *     custom_fields?: array<string, mixed>
     * } $parameters Contact attributes. `email` is required.
     * @return Response The created or updated contact.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $contact = $mm->contacts()->upsert([
     *     'email' => 'john@example.com',
     *     'first_name' => 'John',
     *     'subscribed' => true,
     * ]);
     */
    public function upsert(array $parameters): Response
    {
        $email = $parameters['email'] ?? null;

        if (!is_string($email) || $email === '') {
            throw new InvalidArgumentException('The email field is required for upsert().');
        }

        $existing = $this->findByEmail($email);

        if ($existing !== null) {
            $contactId = $existing['id'] ?? null;

            if (!is_string($contactId) || $contactId === '') {
                throw new ApiException('Contact identified without a usable id.');
            }

            return $this->update($contactId, $parameters);
        }

        return $this->create($parameters);
    }

    /**
     * Mark a contact as subscribed.
     *
     * @param  string  $contactId  Contact UUID.
     * @return Response The updated contact.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $mm->contacts()->subscribe($contactId);
     */
    public function subscribe(string $contactId): Response
    {
        return $this->update($contactId, [
            'subscribed' => true,
            'status' => 'active',
        ]);
    }

    /**
     * Mark a contact as unsubscribed.
     *
     * @param  string  $contactId  Contact UUID.
     * @return Response The updated contact.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * $mm->contacts()->unsubscribe($contactId);
     */
    public function unsubscribe(string $contactId): Response
    {
        return $this->update($contactId, [
            'subscribed' => false,
            'status' => 'unsubscribed',
        ]);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function findByEmail(string $email): ?array
    {
        $matches = $this->list([
            'search' => $email,
            'per_page' => 25,
        ]);

        foreach ($matches as $contact) {
            if (!is_array($contact)) {
                continue;
            }

            $candidate = $contact['email'] ?? null;

            if (is_string($candidate) && strcasecmp($candidate, $email) === 0) {
                return $contact;
            }
        }

        return null;
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

    private function api(): ContactsApi
    {
        return $this->api ??= new ContactsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
