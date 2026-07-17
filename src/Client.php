<?php

declare(strict_types=1);

namespace MailerMine;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use MailerMine\Config\Configuration;
use MailerMine\Contracts\ClientContract;
use MailerMine\Resources\Analytics;
use MailerMine\Resources\ApiKeys;
use MailerMine\Resources\Audiences;
use MailerMine\Resources\Campaigns;
use MailerMine\Resources\Contacts;
use MailerMine\Resources\Domains;
use MailerMine\Resources\Emails;
use MailerMine\Resources\Events;
use MailerMine\Resources\Exports;
use MailerMine\Resources\Imports;
use MailerMine\Resources\Lists;
use MailerMine\Resources\Messages;
use MailerMine\Resources\Projects;
use MailerMine\Resources\Segments;
use MailerMine\Resources\Suppressions;
use MailerMine\Resources\Tags;
use MailerMine\Resources\Templates;
use MailerMine\Resources\Webhooks;
use OpenAPI\Client\Configuration as GeneratedConfiguration;

/**
 * MailerMine SDK client.
 *
 * @example
 *  $mm = new Client(env('MAILERMINE_API_KEY'));
 *  $mm->emails()->send([...]);
 */
final class Client implements ClientContract
{
    /**
     * Current SDK version (SemVer).
     */
    public const VERSION = '1.0.0';

    private readonly Configuration $configuration;

    private readonly GeneratedConfiguration $generatedConfiguration;

    private readonly ClientInterface $httpClient;

    private ?Emails $emails = null;

    private ?Domains $domains = null;

    private ?Templates $templates = null;

    private ?Projects $projects = null;

    private ?ApiKeys $apiKeys = null;

    private ?Contacts $contacts = null;

    private ?Lists $lists = null;

    private ?Segments $segments = null;

    private ?Campaigns $campaigns = null;

    private ?Analytics $analytics = null;

    private ?Webhooks $webhooks = null;

    private ?Suppressions $suppressions = null;

    private ?Imports $imports = null;

    private ?Exports $exports = null;

    private ?Tags $tags = null;

    private ?Audiences $audiences = null;

    private ?Messages $messages = null;

    private ?Events $events = null;

    /**
     * @param  string|Configuration  $apiKeyOrConfig  API key string or Configuration instance
     * @param  string|null  $baseUrl  Optional base URL when passing an API key string
     * @param  ClientInterface|null  $httpClient  Optional Guzzle client (useful for testing)
     */
    public function __construct(
        string|Configuration $apiKeyOrConfig,
        ?string $baseUrl = null,
        ?ClientInterface $httpClient = null,
    ) {
        $this->configuration = $apiKeyOrConfig instanceof Configuration
            ? $apiKeyOrConfig
            : new Configuration(apiKey: $apiKeyOrConfig, baseUrl: $baseUrl);

        $this->generatedConfiguration = $this->configuration->toGenerated();

        $this->httpClient = $httpClient ?? new GuzzleClient([
            'timeout' => $this->configuration->timeout(),
            'connect_timeout' => $this->configuration->timeout(),
            'http_errors' => false,
        ]);
    }

    /**
     * SDK configuration (API key, base URL, timeout).
     */
    public function configuration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @internal Used by resource classes. Do not call from application code.
     */
    public function generatedConfiguration(): GeneratedConfiguration
    {
        return $this->generatedConfiguration;
    }

    /**
     * @internal Used by resource classes. Do not call from application code.
     */
    public function httpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Transactional emails: send, list, retrieve, and track message events.
     */
    public function emails(): Emails
    {
        return $this->emails ??= new Emails($this);
    }

    /**
     * Sending domains: create, verify, and inspect DNS records.
     */
    public function domains(): Domains
    {
        return $this->domains ??= new Domains($this);
    }

    /**
     * Reusable email templates: create, preview, and test.
     */
    public function templates(): Templates
    {
        return $this->templates ??= new Templates($this);
    }

    /**
     * Projects: manage the workspaces that scope your API keys and data.
     */
    public function projects(): Projects
    {
        return $this->projects ??= new Projects($this);
    }

    /**
     * API keys: create, rotate, and revoke project-scoped keys.
     */
    public function apiKeys(): ApiKeys
    {
        return $this->apiKeys ??= new ApiKeys($this);
    }

    /**
     * Contacts: manage your audience, subscriptions, and custom fields.
     */
    public function contacts(): Contacts
    {
        return $this->contacts ??= new Contacts($this);
    }

    /**
     * Lists: manage static contact lists and their membership.
     */
    public function lists(): Lists
    {
        return $this->lists ??= new Lists($this);
    }

    /**
     * Segments: manage dynamic, rule-based audiences.
     */
    public function segments(): Segments
    {
        return $this->segments ??= new Segments($this);
    }

    /**
     * Campaigns: create, schedule, send, and analyze marketing campaigns.
     */
    public function campaigns(): Campaigns
    {
        return $this->campaigns ??= new Campaigns($this);
    }

    /**
     * Analytics: account-wide delivery and engagement metrics.
     */
    public function analytics(): Analytics
    {
        return $this->analytics ??= new Analytics($this);
    }

    /**
     * Webhooks: manage endpoints, deliveries, and signature verification.
     */
    public function webhooks(): Webhooks
    {
        return $this->webhooks ??= new Webhooks($this);
    }

    /**
     * Suppressions: manage the account suppression list.
     */
    public function suppressions(): Suppressions
    {
        return $this->suppressions ??= new Suppressions($this);
    }

    /**
     * Imports: bulk-import contacts from uploaded files.
     */
    public function imports(): Imports
    {
        return $this->imports ??= new Imports($this);
    }

    /**
     * Exports: generate and download data exports.
     */
    public function exports(): Exports
    {
        return $this->exports ??= new Exports($this);
    }

    /**
     * Tags: manage contact tags and their assignments.
     */
    public function tags(): Tags
    {
        return $this->tags ??= new Tags($this);
    }

    /**
     * Audiences: a unified view over lists and segments for campaigns.
     */
    public function audiences(): Audiences
    {
        return $this->audiences ??= new Audiences($this);
    }

    /**
     * Messages: query the message history and delivery logs.
     */
    public function messages(): Messages
    {
        return $this->messages ??= new Messages($this);
    }

    /**
     * Events: query message and delivery lifecycle events.
     */
    public function events(): Events
    {
        return $this->events ??= new Events($this);
    }
}
