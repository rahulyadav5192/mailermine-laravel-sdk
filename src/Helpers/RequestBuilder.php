<?php

declare(strict_types=1);

namespace MailerMine\Helpers;

/**
 * Builds generated OpenAPI request models from plain arrays.
 *
 * Developers pass associative arrays; resources use this helper so they
 * never expose generated model classes in the public API.
 */
final class RequestBuilder
{
    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @param  array<string, mixed>  $parameters
     * @return T
     */
    public static function make(string $class, array $parameters): object
    {
        return new $class($parameters);
    }
}
