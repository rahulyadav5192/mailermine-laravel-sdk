<?php

declare(strict_types=1);

namespace MailerMine\Support;

use ArrayAccess;
use DateTimeInterface;
use JsonSerializable;
use LogicException;
use Stringable;

/**
 * Clean wrapper around a generated API response.
 *
 * Hides OpenAPI model details while preserving access to payload data.
 *
 * @implements ArrayAccess<string, mixed>
 */
final class Response implements ArrayAccess, JsonSerializable
{
    private readonly mixed $payload;

    /**
     * @param  array<string, mixed>  $headers  HTTP response headers, when known.
     */
    public function __construct(
        mixed $raw,
        private readonly array $headers = [],
    ) {
        $this->payload = self::normalize($raw);
    }

    /**
     * HTTP response headers (name => list of values). Empty when unavailable.
     *
     * @return array<string, mixed>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * A single response header value (case-insensitive), or null.
     */
    public function header(string $name): ?string
    {
        foreach ($this->headers as $key => $value) {
            if (strcasecmp((string) $key, $name) === 0) {
                $value = is_array($value) ? ($value[0] ?? null) : $value;

                return is_scalar($value) ? (string) $value : null;
            }
        }

        return null;
    }

    /**
     * Rate-limit state for the request that produced this response.
     */
    public function rateLimit(): ?RateLimit
    {
        return RateLimit::fromHeaders($this->headers);
    }

    /**
     * True when the API replayed a stored response for a repeated Idempotency-Key.
     */
    public function wasIdempotentReplay(): bool
    {
        return strtolower((string) $this->header('Idempotent-Replayed')) === 'true';
    }

    /**
     * Wrap a raw generated response or array in a clean SDK response.
     *
     * @param  array<string, mixed>  $headers
     */
    public static function from(mixed $raw, array $headers = []): self
    {
        return new self($raw, $headers);
    }

    /**
     * Primary payload (`data` when present on the generated model).
     */
    public function data(): mixed
    {
        if (is_array($this->payload) && array_key_exists('data', $this->payload)) {
            return $this->payload['data'];
        }

        return $this->payload;
    }

    /**
     * The human-readable API message, when present.
     */
    public function message(): ?string
    {
        if (is_array($this->payload) && isset($this->payload['message']) && is_string($this->payload['message'])) {
            return $this->payload['message'];
        }

        return null;
    }

    /**
     * The API `success` flag, when present.
     */
    public function success(): ?bool
    {
        if (is_array($this->payload) && isset($this->payload['success']) && is_bool($this->payload['success'])) {
            return $this->payload['success'];
        }

        return null;
    }

    /**
     * Pagination metadata parsed from the response `meta`, when present.
     */
    public function pagination(): ?Pagination
    {
        if (!is_array($this->payload) || !isset($this->payload['meta']) || !is_array($this->payload['meta'])) {
            return null;
        }

        return Pagination::fromArray($this->payload['meta']);
    }

    /**
     * Build a Collection from a list-style response.
     */
    public function collect(): Collection
    {
        $data = $this->data();
        $items = is_array($data) ? array_values($data) : ($data === null ? [] : [$data]);

        return new Collection($items, $this->pagination());
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return is_array($this->payload) ? $this->payload : ['data' => $this->payload];
    }

    /**
     * The full payload, ready for `json_encode()`.
     */
    public function jsonSerialize(): mixed
    {
        return $this->payload;
    }

    /**
     * Whether the given top-level payload key exists (ArrayAccess).
     */
    public function offsetExists(mixed $offset): bool
    {
        $array = $this->toArray();

        return isset($array[$offset]);
    }

    /**
     * Read a top-level payload key, or null when absent (ArrayAccess).
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->toArray()[$offset] ?? null;
    }

    /**
     * Responses are immutable; always throws.
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('MailerMine responses are immutable.');
    }

    /**
     * Responses are immutable; always throws.
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('MailerMine responses are immutable.');
    }

    private static function normalize(mixed $value): mixed
    {
        if ($value instanceof JsonSerializable) {
            return self::normalize($value->jsonSerialize());
        }

        if (is_object($value) && method_exists($value, 'jsonSerialize')) {
            return self::normalize($value->jsonSerialize());
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format(DateTimeInterface::ATOM);
        }

        if ($value instanceof Stringable) {
            return (string) $value;
        }

        if (is_object($value)) {
            return self::normalize(get_object_vars($value));
        }

        if (is_array($value)) {
            return array_map(self::normalize(...), $value);
        }

        return $value;
    }
}
