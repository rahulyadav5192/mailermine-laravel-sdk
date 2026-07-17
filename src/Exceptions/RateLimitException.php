<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use Throwable;

/**
 * Thrown when the API rate limit has been exceeded (HTTP 429).
 *
 * @example
 * use MailerMine\Exceptions\RateLimitException;
 *
 * try {
 *     MailerMine::emails()->send([...]);
 * } catch (RateLimitException $e) {
 *     sleep($e->getRetryAfter() ?? 60);
 * }
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

    /**
     * Seconds to wait before retrying, from the `Retry-After` header, or null.
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
