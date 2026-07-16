<?php

declare(strict_types=1);

namespace MailerMine\Facades;

use Illuminate\Support\Facades\Facade;
use MailerMine\Client;

/**
 * @method static \MailerMine\Resources\Emails emails()
 * @method static \MailerMine\Resources\Domains domains()
 * @method static \MailerMine\Resources\Templates templates()
 * @method static \MailerMine\Resources\Projects projects()
 * @method static \MailerMine\Resources\ApiKeys apiKeys()
 * @method static \MailerMine\Resources\Contacts contacts()
 * @method static \MailerMine\Resources\Lists lists()
 * @method static \MailerMine\Resources\Segments segments()
 * @method static \MailerMine\Resources\Campaigns campaigns()
 * @method static \MailerMine\Resources\Analytics analytics()
 * @method static \MailerMine\Resources\Webhooks webhooks()
 * @method static \MailerMine\Resources\Suppressions suppressions()
 * @method static \MailerMine\Resources\Imports imports()
 * @method static \MailerMine\Resources\Exports exports()
 * @method static \MailerMine\Resources\Tags tags()
 * @method static \MailerMine\Resources\Audiences audiences()
 * @method static \MailerMine\Resources\Messages messages()
 * @method static \MailerMine\Resources\Events events()
 *
 * @see Client
 */
final class MailerMine extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
