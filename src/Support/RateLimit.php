<?php

declare(strict_types=1);

namespace MailerMine\Support;

use DateTimeImmutable;

/**
 * Rate-limit state reported by the API in `X-RateLimit-*` headers.
 *
 * @example
 * $response = $mm->emails()->send([...]);
 * if ($response->rateLimit()?->remaining === 0) {
 *     // back off until $response->rateLimit()->resetsAt
 * }
 */
final class RateLimit
{
    public function __construct(
        public readonly int $limit,
        public readonly int $remaining,
        public readonly ?DateTimeImmutable $resetsAt,
    ) {}

    /**
     * @param  array<string, mixed>  $headers  PSR-7 style headers (name => list<string>|string)
     */
    public static function fromHeaders(array $headers): ?self
    {
        $limit = self::header($headers, 'X-RateLimit-Limit');
        $remaining = self::header($headers, 'X-RateLimit-Remaining');

        if ($limit === null || $remaining === null || !is_numeric($limit) || !is_numeric($remaining)) {
            return null;
        }

        $reset = self::header($headers, 'X-RateLimit-Reset');

        return new self(
            limit: (int) $limit,
            remaining: (int) $remaining,
            resetsAt: $reset !== null && is_numeric($reset)
                ? (new DateTimeImmutable)->setTimestamp((int) $reset)
                : null,
        );
    }

    /**
     * Seconds until the window resets (0 when already reset or unknown).
     */
    public function secondsUntilReset(): int
    {
        return $this->resetsAt === null ? 0 : max(0, $this->resetsAt->getTimestamp() - time());
    }

    /**
     * @param  array<string, mixed>  $headers
     */
    private static function header(array $headers, string $name): ?string
    {
        foreach ($headers as $key => $value) {
            if (strcasecmp((string) $key, $name) !== 0) {
                continue;
            }

            $value = is_array($value) ? ($value[0] ?? null) : $value;

            return is_scalar($value) ? (string) $value : null;
        }

        return null;
    }
}
