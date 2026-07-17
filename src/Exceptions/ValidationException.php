<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

use Throwable;

/**
 * Thrown when a request fails validation (HTTP 422).
 *
 * This is raised both by the MailerMine API and by client-side validation that
 * runs before a request is sent, so a single catch handles both cases. Use
 * {@see ValidationException::getErrors()} to read the per-field messages.
 *
 * @example
 * use MailerMine\Exceptions\ValidationException;
 *
 * try {
 *     MailerMine::emails()->send(['subject' => 'Hi']); // missing "from"/"to"
 * } catch (ValidationException $e) {
 *     foreach ($e->getErrors() as $field => $messages) {
 *         echo $field.': '.implode(' ', $messages).PHP_EOL;
 *     }
 * }
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
     * Build a client-side validation error (raised before a request is sent).
     *
     * @param  array<string, list<string>>  $errors  Per-field validation messages.
     */
    public static function forInput(
        array $errors,
        string $message = 'The given data was invalid.',
        ?Throwable $previous = null,
    ): self {
        return new self(
            message: $message,
            errors: $errors,
            previous: $previous,
        );
    }

    /**
     * Per-field validation messages keyed by field name.
     *
     * @return array<string, mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
