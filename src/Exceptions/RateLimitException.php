<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use Throwable;

/**
 * Thrown when the API rate limit has been exceeded (HTTP 429).
 */
final class RateLimitException extends ApiException
{
    /**
     * @param  array<string, mixed>  $headers
     */
    public function __construct(
        string $message = '',
        int $statusCode = 429,
        mixed $responseBody = null,
        array $headers = [],
        mixed $responseObject = null,
        private readonly ?int $retryAfter = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $responseBody, $headers, $responseObject, $previous);
    }

    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
