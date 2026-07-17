<?php

declare(strict_types=1);

namespace MailerMine\Contracts;

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

/**
 * Contract for the MailerMine SDK client.
 */
interface ClientContract
{
    /** Transactional emails: send, list, retrieve, and track message events. */
    public function emails(): Emails;

    /** Sending domains: create, verify, and inspect DNS records. */
    public function domains(): Domains;

    /** Reusable email templates: create, preview, and test. */
    public function templates(): Templates;

    /** Projects: manage the workspaces that scope your API keys and data. */
    public function projects(): Projects;

    /** API keys: create, rotate, and revoke project-scoped keys. */
    public function apiKeys(): ApiKeys;

    /** Contacts: manage your audience, subscriptions, and custom fields. */
    public function contacts(): Contacts;

    /** Lists: manage static contact lists and their membership. */
    public function lists(): Lists;

    /** Segments: manage dynamic, rule-based audiences. */
    public function segments(): Segments;

    /** Campaigns: create, schedule, send, and analyze marketing campaigns. */
    public function campaigns(): Campaigns;

    /** Analytics: account-wide delivery and engagement metrics. */
    public function analytics(): Analytics;

    /** Webhooks: manage endpoints, deliveries, and signature verification. */
    public function webhooks(): Webhooks;

    /** Suppressions: manage the account suppression list. */
    public function suppressions(): Suppressions;

    /** Imports: bulk-import contacts from uploaded files. */
    public function imports(): Imports;

    /** Exports: generate and download data exports. */
    public function exports(): Exports;

    /** Tags: manage contact tags and their assignments. */
    public function tags(): Tags;

    /** Audiences: a unified view over lists and segments for campaigns. */
    public function audiences(): Audiences;

    /** Messages: query the message history and delivery logs. */
    public function messages(): Messages;

    /** Events: query message and delivery lifecycle events. */
    public function events(): Events;
}
