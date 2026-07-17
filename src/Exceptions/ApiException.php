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

    /**
     * The HTTP status code, or 0 for client-side/transport errors.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * The decoded response body, when available.
     */
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

    /**
     * The raw generated response object, when available.
     */
    public function getResponseObject(): mixed
    {
        return $this->responseObject;
    }

    /**
     * The MailerMine request ID from the error response, when available.
     *
     * Include this when contacting support so a request can be traced.
     */
    public function getRequestId(): ?string
    {
        $body = $this->responseBody;

        if (is_object($body) && isset($body->request_id) && is_string($body->request_id)) {
            return $body->request_id;
        }

        if (is_array($body) && isset($body['request_id']) && is_string($body['request_id'])) {
            return $body['request_id'];
        }

        foreach (['X-Request-Id', 'x-request-id'] as $header) {
            if (isset($this->headers[$header])) {
                $value = $this->headers[$header];
                $value = is_array($value) ? ($value[0] ?? null) : $value;

                if (is_string($value) && $value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * Whether this is a 4xx client error.
     */
    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * Whether this is a 5xx server error.
     */
    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }
}
