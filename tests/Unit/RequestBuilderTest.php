<?php

declare(strict_types=1);

namespace MailerMine\Tests\Unit;

use MailerMine\Exceptions\ValidationException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Tests\TestCase;
use OpenAPI\Client\Model\SendEmailRequest;

final class RequestBuilderTest extends TestCase
{
    public function test_it_builds_a_valid_model(): void
    {
        $model = RequestBuilder::make(SendEmailRequest::class, [
            'from' => 'hello@mailermine.com',
            'to' => ['john@example.com'],
            'subject' => 'Hello',
            'html' => '<h1>Hello</h1>',
        ]);

        $this->assertInstanceOf(SendEmailRequest::class, $model);
        $this->assertSame('hello@mailermine.com', $model->getFrom());
    }

    public function test_it_raises_friendly_validation_errors_for_missing_required_fields(): void
    {
        try {
            RequestBuilder::make(SendEmailRequest::class, ['subject' => 'Hello']);
            $this->fail('Expected a ValidationException.');
        } catch (ValidationException $exception) {
            $this->assertSame(422, $exception->getStatusCode());
            $this->assertNotEmpty($exception->getErrors());
        }
    }

    public function test_the_validation_error_keys_map_to_field_names(): void
    {
        try {
            RequestBuilder::make(SendEmailRequest::class, [
                'to' => ['john@example.com'],
                'subject' => 'Hello',
            ]);
            $this->fail('Expected a ValidationException.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('from', $exception->getErrors());
        }
    }

    public function test_invalid_enum_values_are_rejected_with_the_field_name(): void
    {
        try {
            RequestBuilder::make(\OpenAPI\Client\Model\CreateContactRequest::class, [
                'email' => 'john@example.com',
                'status' => 'not-a-real-status',
            ]);
            $this->fail('Expected a ValidationException.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('status', $exception->getErrors());
        }
    }
}
