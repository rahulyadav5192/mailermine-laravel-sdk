<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use Exception;
use Throwable;

/**
 * Base exception for all MailerMine SDK errors.
 */
class ApiException extends Exception
{
    /**
     * @param  array<string, mixed>  $headers
     */
    public function __construct(
        string $message = '',
        private readonly int $statusCode = 0,
        private readonly mixed $responseBody = null,
        private readonly array $headers = [],
        private readonly mixed $responseObject = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseBody(): mixed
    {
        return $this->responseBody;
    }

    /**
     * @return array<string, mixed>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getResponseObject(): mixed
    {
        return $this->responseObject;
    }

    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }
}
