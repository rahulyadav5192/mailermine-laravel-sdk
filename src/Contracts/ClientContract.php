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
    public function emails(): Emails;

    public function domains(): Domains;

    public function templates(): Templates;

    public function projects(): Projects;

    public function apiKeys(): ApiKeys;

    public function contacts(): Contacts;

    public function lists(): Lists;

    public function segments(): Segments;

    public function campaigns(): Campaigns;

    public function analytics(): Analytics;

    public function webhooks(): Webhooks;

    public function suppressions(): Suppressions;

    public function imports(): Imports;

    public function exports(): Exports;

    public function tags(): Tags;

    public function audiences(): Audiences;

    public function messages(): Messages;

    public function events(): Events;
}
