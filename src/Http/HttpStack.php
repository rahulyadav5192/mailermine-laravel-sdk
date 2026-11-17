<?php

declare(strict_types=1);

namespace MailerMine\Http;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use MailerMine\Config\Configuration;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Builds the Guzzle handler stack used by the default SDK HTTP client.
 *
 * - Adds an `Idempotency-Key` to every `POST /emails` that does not already
 *   carry one, so a retried send is never delivered twice.
 * - Retries rate-limited (429) and temporarily unavailable (502/503/504)
 *   responses and connection failures, honouring `Retry-After` and backing
 *   off exponentially with jitter. Non-idempotent requests (POST/PATCH
 *   without an `Idempotency-Key`) are only retried on 429, which the API
 *   returns before doing any work.
 */
final class HttpStack
{
    public const IDEMPOTENCY_HEADER = 'Idempotency-Key';

    private const SAFE_METHODS = ['GET', 'HEAD', 'OPTIONS', 'PUT', 'DELETE'];

    private const RETRYABLE_STATUSES = [502, 503, 504];

    public static function create(Configuration $configuration): HandlerStack
    {
        $stack = HandlerStack::create();

        // Order matters: the first pushed middleware is the outermost, so the
        // idempotency key is attached once and reused by every retry attempt.
        $stack->push(self::idempotencyMiddleware(), 'mailermine_idempotency');

        if ($configuration->maxRetries() > 0) {
            $stack->push(Middleware::retry(
                self::decider($configuration),
                self::delay($configuration),
            ), 'mailermine_retry');
        }

        return $stack;
    }

    public static function generateIdempotencyKey(): string
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0F) | 0x40); // version 4
        $bytes[8] = chr((ord($bytes[8]) & 0x3F) | 0x80); // RFC 4122 variant

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    private static function idempotencyMiddleware(): callable
    {
        return static fn (callable $handler): callable => static function (RequestInterface $request, array $options) use ($handler) {
            if (
                strtoupper($request->getMethod()) === 'POST'
                && !$request->hasHeader(self::IDEMPOTENCY_HEADER)
                && preg_match('#/emails/?$#', $request->getUri()->getPath()) === 1
            ) {
                $request = $request->withHeader(self::IDEMPOTENCY_HEADER, self::generateIdempotencyKey());
            }

            return $handler($request, $options);
        };
    }

    private static function decider(Configuration $configuration): callable
    {
        return static function (
            int $retries,
            RequestInterface $request,
            ?ResponseInterface $response = null,
            ?Throwable $exception = null,
        ) use ($configuration): bool {
            if ($retries >= $configuration->maxRetries()) {
                return false;
            }

            $replayable = in_array(strtoupper($request->getMethod()), self::SAFE_METHODS, true)
                || $request->hasHeader(self::IDEMPOTENCY_HEADER);

            if ($exception instanceof ConnectException) {
                return $replayable;
            }

            if ($response === null) {
                return false;
            }

            $status = $response->getStatusCode();

            if ($status === 429) {
                $retryAfter = self::retryAfterSeconds($response);

                // Do not block for longer than the caller allows; surface the
                // RateLimitException (with getRetryAfter()) instead.
                return $retryAfter === null || $retryAfter <= $configuration->maxRetryDelay();
            }

            return in_array($status, self::RETRYABLE_STATUSES, true) && $replayable;
        };
    }

    private static function delay(Configuration $configuration): callable
    {
        return static function (int $retries, ?ResponseInterface $response = null) use ($configuration): int {
            $retryAfter = $response !== null ? self::retryAfterSeconds($response) : null;

            if ($retryAfter !== null) {
                return (int) (min($retryAfter, $configuration->maxRetryDelay()) * 1000);
            }

            $base = 500 * (2 ** max(0, $retries - 1));
            $jitter = random_int(0, 250);

            return (int) min($base + $jitter, $configuration->maxRetryDelay() * 1000);
        };
    }

    private static function retryAfterSeconds(ResponseInterface $response): ?float
    {
        $value = $response->getHeaderLine('Retry-After');

        if ($value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return max(0.0, (float) $value);
        }

        $timestamp = strtotime($value);

        return $timestamp === false ? null : max(0.0, (float) ($timestamp - time()));
    }
}
