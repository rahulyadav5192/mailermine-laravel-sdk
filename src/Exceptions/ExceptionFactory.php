<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use OpenAPI\Client\ApiException as GeneratedApiException;

/**
 * Maps generated OpenAPI exceptions into friendly SDK exceptions.
 */
final class ExceptionFactory
{
    public static function fromGenerated(GeneratedApiException $exception): ApiException
    {
        $statusCode = $exception->getCode();
        $message = self::resolveMessage($exception);
        $headers = $exception->getResponseHeaders() ?? [];
        $body = $exception->getResponseBody();
        $object = $exception->getResponseObject();

        return match (true) {
            $statusCode === 401, $statusCode === 403 => new AuthenticationException(
                message: $message !== '' ? $message : 'Authentication failed. Check your API key.',
                statusCode: $statusCode,
                responseBody: $body,
                headers: $headers,
                responseObject: $object,
                previous: $exception,
            ),
            $statusCode === 404 => new NotFoundException(
                message: $message !== '' ? $message : 'The requested resource was not found.',
                statusCode: $statusCode,
                responseBody: $body,
                headers: $headers,
                responseObject: $object,
                previous: $exception,
            ),
            $statusCode === 422 => new ValidationException(
                message: $message !== '' ? $message : 'The given data was invalid.',
                statusCode: $statusCode,
                responseBody: $body,
                headers: $headers,
                responseObject: $object,
                errors: self::extractErrors($body, $object),
                previous: $exception,
            ),
            $statusCode === 429 => new RateLimitException(
                message: $message !== '' ? $message : 'Too many requests. Please try again later.',
                statusCode: $statusCode,
                responseBody: $body,
                headers: $headers,
                responseObject: $object,
                retryAfter: self::extractRetryAfter($headers),
                previous: $exception,
            ),
            default => new ApiException(
                message: $message !== '' ? $message : sprintf('API request failed with status %d.', $statusCode),
                statusCode: $statusCode,
                responseBody: $body,
                headers: $headers,
                responseObject: $object,
                previous: $exception,
            ),
        };
    }

    private static function resolveMessage(GeneratedApiException $exception): string
    {
        $object = $exception->getResponseObject();

        if (is_object($object) && method_exists($object, 'getMessage')) {
            $message = $object->getMessage();

            if (is_string($message) && $message !== '') {
                return $message;
            }
        }

        $body = $exception->getResponseBody();

        if (is_object($body) && isset($body->message) && is_string($body->message)) {
            return $body->message;
        }

        if (is_array($body) && isset($body['message']) && is_string($body['message'])) {
            return $body['message'];
        }

        $raw = $exception->getMessage();

        // Strip Guzzle-style noise; keep a short, developer-friendly message.
        if (str_contains($raw, '[url]')) {
            return trim(explode('[url]', $raw)[0]);
        }

        return $raw;
    }

    /**
     * @param  array<string, mixed>  $headers
     */
    private static function extractRetryAfter(array $headers): ?int
    {
        foreach (['Retry-After', 'retry-after'] as $key) {
            if (!isset($headers[$key])) {
                continue;
            }

            $value = $headers[$key];

            if (is_array($value)) {
                $value = $value[0] ?? null;
            }

            if (is_numeric($value)) {
                return (int) $value;
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    private static function extractErrors(mixed $body, mixed $object): array
    {
        if (is_object($object) && method_exists($object, 'getErrors')) {
            $errors = $object->getErrors();

            return is_array($errors) ? $errors : [];
        }

        if (is_object($body) && isset($body->errors) && is_array($body->errors)) {
            return $body->errors;
        }

        if (is_array($body) && isset($body['errors']) && is_array($body['errors'])) {
            return $body['errors'];
        }

        return [];
    }
}
