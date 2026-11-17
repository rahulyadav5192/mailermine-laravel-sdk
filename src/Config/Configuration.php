<?php

declare(strict_types=1);

namespace MailerMine\Config;

use InvalidArgumentException;

/**
 * SDK-level configuration. Builds the generated OpenAPI Configuration internally.
 */
final class Configuration
{
    public const DEFAULT_USER_AGENT = 'mailermine-php/1.1.0';

    public const DEFAULT_MAX_RETRIES = 2;

    public const DEFAULT_MAX_RETRY_DELAY = 30.0;

    public const DEFAULT_BASE_URL = 'https://mailermine.com/api/v1';

    public function __construct(
        private readonly string $apiKey,
        private readonly ?string $baseUrl = null,
        private readonly float $timeout = 30.0,
        private readonly string $userAgent = self::DEFAULT_USER_AGENT,
        private readonly bool $debug = false,
        private readonly int $maxRetries = self::DEFAULT_MAX_RETRIES,
        private readonly float $maxRetryDelay = self::DEFAULT_MAX_RETRY_DELAY,
    ) {
        if ($this->apiKey === '') {
            throw new InvalidArgumentException('MailerMine API key must not be empty.');
        }

        if ($this->timeout <= 0) {
            throw new InvalidArgumentException('MailerMine timeout must be greater than zero.');
        }

        if ($this->maxRetries < 0) {
            throw new InvalidArgumentException('MailerMine max retries must be zero or greater.');
        }

        if ($this->maxRetryDelay < 0) {
            throw new InvalidArgumentException('MailerMine max retry delay must be zero or greater.');
        }
    }

    /**
     * @param  array<string, mixed>  $config
     */
    public static function fromArray(array $config): self
    {
        $apiKey = $config['api_key'] ?? $config['apiKey'] ?? '';

        if (!is_string($apiKey) || $apiKey === '') {
            throw new InvalidArgumentException('MailerMine API key is required.');
        }

        return new self(
            apiKey: $apiKey,
            baseUrl: isset($config['base_url']) && is_string($config['base_url']) && $config['base_url'] !== ''
                ? $config['base_url']
                : (isset($config['baseUrl']) && is_string($config['baseUrl']) && $config['baseUrl'] !== ''
                    ? $config['baseUrl']
                    : null),
            timeout: isset($config['timeout']) ? (float) $config['timeout'] : 30.0,
            userAgent: isset($config['user_agent']) && is_string($config['user_agent'])
                ? $config['user_agent']
                : (isset($config['userAgent']) && is_string($config['userAgent'])
                    ? $config['userAgent']
                    : self::DEFAULT_USER_AGENT),
            debug: (bool) ($config['debug'] ?? false),
            maxRetries: isset($config['max_retries']) && is_numeric($config['max_retries'])
                ? (int) $config['max_retries']
                : (isset($config['maxRetries']) && is_numeric($config['maxRetries']) ? (int) $config['maxRetries'] : self::DEFAULT_MAX_RETRIES),
            maxRetryDelay: isset($config['max_retry_delay']) && is_numeric($config['max_retry_delay'])
                ? (float) $config['max_retry_delay']
                : self::DEFAULT_MAX_RETRY_DELAY,
        );
    }

    /**
     * The MailerMine API key used to authenticate requests.
     */
    public function apiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * The configured base URL, or the MailerMine production URL when unset.
     */
    public function baseUrl(): string
    {
        return $this->baseUrl ?? self::DEFAULT_BASE_URL;
    }

    /**
     * The request timeout in seconds.
     */
    public function timeout(): float
    {
        return $this->timeout;
    }

    /**
     * The User-Agent header sent with every request.
     */
    public function userAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * Whether generated-client debug logging is enabled.
     */
    public function debug(): bool
    {
        return $this->debug;
    }

    /**
     * How many times a failed request is retried (0 disables retries).
     */
    public function maxRetries(): int
    {
        return $this->maxRetries;
    }

    /**
     * The longest single wait between retries, in seconds. A 429 asking the
     * client to wait longer than this is surfaced as a RateLimitException.
     */
    public function maxRetryDelay(): float
    {
        return $this->maxRetryDelay;
    }

    /**
     * Create the generated OpenAPI Configuration used by API classes.
     */
    public function toGenerated(): \OpenAPI\Client\Configuration
    {
        $generated = new \OpenAPI\Client\Configuration;
        $generated->setAccessToken($this->apiKey);
        $generated->setUserAgent($this->userAgent);
        $generated->setDebug($this->debug);
        $generated->setHost(rtrim($this->baseUrl(), '/'));

        return $generated;
    }
}
