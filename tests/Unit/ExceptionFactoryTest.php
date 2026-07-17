<?php

declare(strict_types=1);

namespace MailerMine\Tests\Unit;

use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\AuthenticationException;
use MailerMine\Exceptions\ExceptionFactory;
use MailerMine\Exceptions\PlanException;
use MailerMine\Exceptions\RateLimitException;
use MailerMine\Exceptions\ValidationException;
use MailerMine\Tests\TestCase;
use OpenAPI\Client\ApiException as GeneratedApiException;

final class ExceptionFactoryTest extends TestCase
{
    public function test_it_maps_401_to_authentication_exception(): void
    {
        $generated = new GeneratedApiException('Unauthorized', 401, [], (object) ['message' => 'Invalid API key']);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertInstanceOf(AuthenticationException::class, $exception);
        $this->assertSame(401, $exception->getStatusCode());
        $this->assertSame('Invalid API key', $exception->getMessage());
    }

    public function test_it_maps_403_to_plan_exception_with_upgrade_guidance(): void
    {
        $generated = new GeneratedApiException('Forbidden', 403, [], (object) [
            'message' => 'Custom headers require the Pro plan',
        ]);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertInstanceOf(PlanException::class, $exception);
        $this->assertNotInstanceOf(AuthenticationException::class, $exception);
        $this->assertSame(403, $exception->getStatusCode());
        $this->assertStringContainsString('Custom headers require the Pro plan', $exception->getMessage());
        $this->assertStringContainsString(PlanException::UPGRADE_URL, $exception->getMessage());
        $this->assertSame(PlanException::UPGRADE_URL, $exception->getUpgradeUrl());
    }

    public function test_it_provides_default_plan_message_when_body_is_empty(): void
    {
        $generated = new GeneratedApiException('', 403, [], null);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertInstanceOf(PlanException::class, $exception);
        $this->assertStringContainsString('not available on your current MailerMine plan', $exception->getMessage());
        $this->assertStringContainsString(PlanException::UPGRADE_URL, $exception->getMessage());
    }

    public function test_it_exposes_request_id_from_error_body(): void
    {
        $generated = new GeneratedApiException('Forbidden', 403, [], (object) [
            'message' => 'Account suspended',
            'request_id' => 'req_123',
        ]);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertSame('req_123', $exception->getRequestId());
    }

    public function test_it_maps_422_to_validation_exception(): void
    {
        $generated = new GeneratedApiException('Unprocessable', 422, [], (object) [
            'message' => 'Validation failed',
            'errors' => ['email' => ['required']],
        ]);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertInstanceOf(ValidationException::class, $exception);
        $this->assertSame(['email' => ['required']], $exception->getErrors());
    }

    public function test_it_maps_429_to_rate_limit_exception(): void
    {
        $generated = new GeneratedApiException('Too Many', 429, ['Retry-After' => ['60']], null);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertInstanceOf(RateLimitException::class, $exception);
        $this->assertSame(60, $exception->getRetryAfter());
    }

    public function test_it_maps_other_status_codes_to_api_exception(): void
    {
        $generated = new GeneratedApiException('Boom', 500, [], null);

        $exception = ExceptionFactory::fromGenerated($generated);

        $this->assertInstanceOf(ApiException::class, $exception);
        $this->assertFalse($exception instanceof AuthenticationException);
        $this->assertTrue($exception->isServerError());
    }
}
