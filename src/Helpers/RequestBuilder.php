<?php

declare(strict_types=1);

namespace MailerMine\Helpers;

use MailerMine\Exceptions\ValidationException;
use Throwable;

/**
 * Builds generated OpenAPI request models from plain arrays.
 *
 * Developers pass associative arrays; resources use this helper so they never
 * expose generated model classes in the public API. Before the model is handed
 * back, its own validation metadata is inspected so invalid payloads raise a
 * friendly {@see ValidationException} (with per-field messages) up front, rather
 * than surfacing a generated exception or a cryptic API error later.
 */
final class RequestBuilder
{
    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @param  array<string, mixed>  $parameters
     * @return T
     *
     * @throws ValidationException When the payload cannot build a valid request.
     */
    public static function make(string $class, array $parameters): object
    {
        try {
            $model = new $class($parameters);
        } catch (Throwable $exception) {
            throw ValidationException::forInput(
                ['request' => [self::shortName($class).' could not be built from the given data.']],
                'The request payload was invalid.',
                $exception,
            );
        }

        self::guardAgainstInvalidProperties($model);

        return $model;
    }

    /**
     * Convert a generated model's own validation results into a friendly
     * SDK exception. No generated exception is ever allowed to escape.
     */
    private static function guardAgainstInvalidProperties(object $model): void
    {
        if (!method_exists($model, 'listInvalidProperties')) {
            return;
        }

        // The generated listInvalidProperties() is not always null-safe (for
        // example it calls count()/mb_strlen() on missing fields). Suppress the
        // resulting deprecations/warnings and treat a hard failure as a payload
        // we cannot enumerate, so no generated error ever escapes.
        set_error_handler(static fn (): bool => true);

        try {
            $violations = $model->listInvalidProperties();
        } catch (Throwable $exception) {
            throw ValidationException::forInput(
                ['request' => ['One or more required fields are missing or invalid.']],
                'The request payload was invalid.',
                $exception,
            );
        } finally {
            restore_error_handler();
        }

        if (!is_array($violations) || $violations === []) {
            return;
        }

        $errors = [];

        foreach ($violations as $violation) {
            if (!is_string($violation) || $violation === '') {
                continue;
            }

            $field = self::fieldFromViolation($violation) ?? 'request';
            $errors[$field][] = $violation;
        }

        if ($errors === []) {
            return;
        }

        throw ValidationException::forInput($errors);
    }

    /**
     * Extract the offending field name from a generated violation message such
     * as `'from' can't be null` or `invalid value for 'to', ...`.
     */
    private static function fieldFromViolation(string $violation): ?string
    {
        if (preg_match("/for '([^']+)'/", $violation, $matches) === 1) {
            return $matches[1];
        }

        if (preg_match("/'([^']+)'/", $violation, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }

    /**
     * @param  class-string  $class
     */
    private static function shortName(string $class): string
    {
        $parts = explode('\\', $class);

        return end($parts) ?: $class;
    }
}
