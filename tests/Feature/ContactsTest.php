<?php

declare(strict_types=1);

namespace MailerMine\Tests\Feature;

use MailerMine\Exceptions\NotFoundException;
use MailerMine\Exceptions\ValidationException;
use MailerMine\Support\Collection;
use MailerMine\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

final class ContactsTest extends TestCase
{
    use MocksMailerMineApi;

    public function test_contact_crud_search_and_subscription_helpers(): void
    {
        $history = [];
        $contact = [
            'id' => 'contact-1',
            'email' => 'john@example.com',
            'first_name' => 'John',
            'subscribed' => true,
            'status' => 'active',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(201, $this->resource($contact)),
            $this->mockJsonResponse(200, $this->list([$contact])),
            $this->mockJsonResponse(200, $this->resource($contact)),
            $this->mockJsonResponse(200, $this->resource([...$contact, 'first_name' => 'Jonathan'])),
            $this->mockJsonResponse(200, ['success' => true, 'message' => 'Deleted.', 'data' => []]),
            $this->mockJsonResponse(200, $this->list([$contact])),
            $this->mockJsonResponse(200, $this->resource([...$contact, 'subscribed' => true, 'status' => 'active'])),
            $this->mockJsonResponse(200, $this->resource([...$contact, 'subscribed' => false, 'status' => 'unsubscribed'])),
        ], $history);

        $created = $client->contacts()->create([
            'email' => 'john@example.com',
            'first_name' => 'John',
        ]);
        $listed = $client->contacts()->list(['subscribed' => true, 'page' => 1]);
        $retrieved = $client->contacts()->get('contact-1');
        $updated = $client->contacts()->update('contact-1', ['first_name' => 'Jonathan']);
        $deleted = $client->contacts()->delete('contact-1');
        $searched = $client->contacts()->search('john@example.com');
        $subscribed = $client->contacts()->subscribe('contact-1');
        $unsubscribed = $client->contacts()->unsubscribe('contact-1');

        self::assertSame('contact-1', $created->data()['id']);
        self::assertInstanceOf(Collection::class, $listed);
        self::assertSame(1, $listed->pagination()?->currentPage);
        self::assertSame('contact-1', $retrieved->data()['id']);
        self::assertSame('Jonathan', $updated->data()['first_name']);
        self::assertTrue($deleted->success());
        self::assertSame('john@example.com', $searched->first()['email']);
        self::assertTrue($subscribed->data()['subscribed']);
        self::assertFalse($unsubscribed->data()['subscribed']);

        self::assertSame('/api/v1/contacts', $this->historyRequest($history, 0)->getUri()->getPath());
        self::assertSame('john@example.com', $this->body($this->historyRequest($history, 0))['email']);
        parse_str($this->historyRequest($history, 1)->getUri()->getQuery(), $query);
        self::assertTrue(filter_var($query['subscribed'] ?? null, FILTER_VALIDATE_BOOLEAN));
        parse_str($this->historyRequest($history, 5)->getUri()->getQuery(), $searchQuery);
        self::assertSame('john@example.com', $searchQuery['search']);
        self::assertTrue($this->body($this->historyRequest($history, 6))['subscribed']);
        self::assertFalse($this->body($this->historyRequest($history, 7))['subscribed']);
    }

    public function test_identify_and_upsert_use_email_lookup(): void
    {
        $history = [];
        $existing = [
            'id' => 'contact-1',
            'email' => 'john@example.com',
            'first_name' => 'John',
        ];

        $client = $this->mockClient([
            $this->mockJsonResponse(200, $this->list([$existing])),
            $this->mockJsonResponse(200, $this->list([$existing])),
            $this->mockJsonResponse(200, $this->resource([...$existing, 'first_name' => 'Jonathan'])),
            $this->mockJsonResponse(200, $this->list([])),
            $this->mockJsonResponse(201, $this->resource([
                'id' => 'contact-2',
                'email' => 'new@example.com',
                'first_name' => 'New',
            ])),
            $this->mockJsonResponse(200, $this->list([])),
        ], $history);

        $identified = $client->contacts()->identify('john@example.com');
        $updated = $client->contacts()->upsert([
            'email' => 'john@example.com',
            'first_name' => 'Jonathan',
        ]);
        $created = $client->contacts()->upsert([
            'email' => 'new@example.com',
            'first_name' => 'New',
        ]);

        self::assertSame('contact-1', $identified->data()['id']);
        self::assertSame('Jonathan', $updated->data()['first_name']);
        self::assertSame('contact-2', $created->data()['id']);

        $this->expectException(NotFoundException::class);
        $client->contacts()->identify('missing@example.com');
    }

    public function test_contact_validation_errors_are_mapped(): void
    {
        $client = $this->mockClient([
            $this->mockJsonResponse(422, [
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => ['email' => ['The email field is required.']],
            ]),
        ]);

        try {
            $client->contacts()->create(['first_name' => 'John']);
            self::fail('Expected ValidationException.');
        } catch (ValidationException $exception) {
            self::assertSame(['email' => ['The email field is required.']], $exception->getErrors());
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function resource(array $data): array
    {
        return ['success' => true, 'message' => 'OK', 'data' => $data];
    }

    /**
     * @param  list<array<string, mixed>>  $data
     * @return array<string, mixed>
     */
    private function list(array $data): array
    {
        return [
            'success' => true,
            'message' => 'OK',
            'data' => $data,
            'meta' => [
                'current_page' => 1,
                'per_page' => 25,
                'total' => count($data),
                'last_page' => 1,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function body(RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
