<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use Throwable;

/**
 * Thrown when the API key is valid but lacks a scope the endpoint requires
 * (HTTP 403 with `errors.scope`). Create a key with the listed scope, or use a
 * full-access key.
 *
 * @example
 * try {
 *     $mm->domains()->list();
 * } catch (MissingScopeException $e) {
 *     logger()->error('Key needs: '.implode(', ', $e->getMissingScopes()));
 * }
 */
final class MissingScopeException extends ApiException
{
    /**
     * @param  array<string, mixed>  $headers
     * @param  list<string>  $missingScopes
     */
    public function __construct(
        string $message = '',
        int $statusCode = 403,
        mixed $responseBody = null,
        array $headers = [],
        mixed $responseObject = null,
        private readonly array $missingScopes = [],
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $responseBody, $headers, $responseObject, $previous);
    }

    /**
     * @return list<string> Scopes the key would need, e.g. ['domains.read'].
     */
    public function getMissingScopes(): array
    {
        return $this->missingScopes;
    }
}
