<?php

declare(strict_types=1);

namespace MailerMine\Support;

use ReflectionClass;

/**
 * API key scopes. A `.write` scope also grants the matching `.read` scope;
 * `admin` grants everything; a key created without scopes has full access.
 *
 * @example
 * $mm->apiKeys()->create($projectId, ['name' => 'Mailer', 'scopes' => Scope::SENDING_ONLY]);
 */
final class Scope
{
    public const EMAILS_SEND = 'emails.send';

    public const EMAILS_READ = 'emails.read';

    public const TEMPLATES_READ = 'templates.read';

    public const TEMPLATES_WRITE = 'templates.write';

    public const DOMAINS_READ = 'domains.read';

    public const DOMAINS_WRITE = 'domains.write';

    public const CONTACTS_READ = 'contacts.read';

    public const CONTACTS_WRITE = 'contacts.write';

    public const CAMPAIGNS_READ = 'campaigns.read';

    public const CAMPAIGNS_WRITE = 'campaigns.write';

    public const ANALYTICS_READ = 'analytics.read';

    public const BILLING_READ = 'billing.read';

    public const PROJECTS_READ = 'projects.read';

    public const PROJECTS_WRITE = 'projects.write';

    public const API_KEYS_READ = 'api_keys.read';

    public const API_KEYS_WRITE = 'api_keys.write';

    public const WEBHOOKS_READ = 'webhooks.read';

    public const WEBHOOKS_WRITE = 'webhooks.write';

    public const SUPPRESSIONS_READ = 'suppressions.read';

    public const SUPPRESSIONS_WRITE = 'suppressions.write';

    public const EVENTS_READ = 'events.read';

    public const ADMIN = 'admin';

    /** Send email only. */
    public const SENDING_ONLY = [self::EMAILS_SEND];

    /** Send email and read delivery logs, events and analytics. */
    public const SENDING_AND_LOGS = [self::EMAILS_SEND, self::EMAILS_READ, self::EVENTS_READ, self::ANALYTICS_READ];

    /** Manage contacts and campaigns; read templates and analytics. */
    public const MARKETING = [
        self::CONTACTS_READ, self::CONTACTS_WRITE, self::CAMPAIGNS_READ, self::CAMPAIGNS_WRITE,
        self::TEMPLATES_READ, self::ANALYTICS_READ,
    ];

    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return array_values(array_filter(
            (new ReflectionClass(self::class))->getConstants(),
            static fn (mixed $value): bool => is_string($value),
        ));
    }
}
