<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use Throwable;

/**
 * Thrown when the request fails validation (HTTP 422).
 */
final class ValidationException extends ApiException
{
    /**
     * @param  array<string, mixed>  $errors
     * @param  array<string, mixed>  $headers
     */
    public function __construct(
        string $message = '',
        int $statusCode = 422,
        mixed $responseBody = null,
        array $headers = [],
        mixed $responseObject = null,
        private readonly array $errors = [],
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $responseBody, $headers, $responseObject, $previous);
    }

    /**
     * @return array<string, mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
