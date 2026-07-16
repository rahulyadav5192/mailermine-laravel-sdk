# MailerMine Laravel SDK — v1.0.0 Release Decision

**Package:** `mailermine/mailermine`
**Version:** 1.0.0
**Decision date:** 2026-07-17
**Status:** **APPROVED FOR PUBLIC RELEASE**

---

## Final release decision

Ship **v1.0.0**. The SDK is feature-complete, architecturally stable, and
production-ready. No further architectural changes are required before
publishing to GitHub and Packagist.

A Laravel developer can install the package and integrate MailerMine within
minutes:

```bash
composer require mailermine/mailermine
```

---

## Architecture

| Layer | Responsibility |
| ----- | -------------- |
| `src/` | Public handwritten SDK (Client, resources, support types, Laravel) |
| `generated/` | OpenAPI-generated HTTP client — **internal only** |
| `config/` | Publishable Laravel configuration |
| `docs/` | Human guides |
| `examples/` | Runnable samples |

Public namespaces developers should use:

- `MailerMine\Client`
- `MailerMine\Facades\MailerMine`
- `MailerMine\Resources\*`
- `MailerMine\Support\{Response, Collection, Pagination}`
- `MailerMine\Exceptions\*`
- `MailerMine\Config\Configuration`
- `MailerMine\Contracts\ClientContract`

Developers should **never** inspect or depend on `OpenAPI\Client\*`.
`Client::generatedConfiguration()` and `Client::httpClient()` are marked
`@internal`.

---

## Features

- Transactional email (attachments, CC/BCC, templates, tags, metadata)
- Domains + DNS verification
- Templates
- Contacts, lists, audiences, segments, tags
- Imports / exports
- Campaigns (create, schedule, send, lifecycle, analytics, events)
- Account analytics
- Message events & delivery logs
- Webhooks (CRUD, deliveries, replay, HMAC verify)
- Suppressions
- Laravel auto-discovery, facade, DI, publishable config
- Pure PHP support (no Laravel required)

---

## Coverage

| Metric | Value |
| ------ | ----- |
| Resource classes | 18 |
| Public resource methods | ~170+ |
| Test files | 23 |
| Tests / assertions | 69 / 705+ |
| PHPStan | Level 8, clean |
| Pint | Clean |
| CI matrix | PHP 8.3/8.4 × Laravel 12/13 |

---

## Resources

`emails`, `domains`, `templates`, `projects`, `apiKeys`, `contacts`, `lists`,
`audiences`, `segments`, `tags`, `imports`, `exports`, `campaigns`,
`analytics`, `events`, `messages`, `webhooks`, `suppressions`

---

## Examples (canonical)

| File | Purpose |
| ---- | ------- |
| `examples/send-email.php` | Transactional send |
| `examples/attachments.php` | File attachments |
| `examples/verify-domain.php` | Domain + DNS verify |
| `examples/create-template.php` | Template create/preview |
| `examples/import-contacts.php` | CSV import |
| `examples/create-campaign.php` | Campaign create/schedule |
| `examples/analytics.php` | Analytics overview |
| `examples/webhooks.php` | Webhooks + signature verify |
| `examples/customer-smoke.php` | End-to-end customer smoke |

---

## Documentation

- README (install, usage, errors, testing)
- `docs/` — installation, quick-start, authentication, transactional, domains,
  templates, contacts, campaigns, analytics, webhooks, FAQ, troubleshooting,
  migration
- `docs/website/` — copy for mailermine.com
- Community: LICENSE, CHANGELOG, CONTRIBUTING, SECURITY, CODE_OF_CONDUCT,
  ROADMAP, SUPPORTED_VERSIONS, UPGRADE, RELEASE_CHECKLIST

---

## Known limitations

1. **Packagist listing** must be submitted after the GitHub tag is pushed
   (manual Packagist step). Until then, `composer require mailermine/mailermine`
   from Packagist will not resolve.
2. Automatic retries / idempotency helpers are planned (see ROADMAP), not in
   1.0.0.
3. Generated OpenAPI PHPDoc incorrectly types some date query params as
   `\DateTime`; the SDK correctly passes ISO-8601 strings (documented PHPStan
   ignore).
4. GitHub repository currently lives at
   `rahulyadav5192/mailermine-laravel-sdk`. Transfer to a `mailermine` org is
   optional for branding.

---

## Future roadmap

See [ROADMAP.md](ROADMAP.md):

- Optional retries with backoff
- Idempotency-key helpers
- Typed response DTOs
- Pagination iterators (`each` / `lazy`)
- Laravel notification channel

---

## Publish sequence

1. Commit release candidates to `main`
2. Tag `v1.0.0` and push tag + branch
3. Publish GitHub Release using `.github/release/v1.0.0.md`
4. Submit repository on Packagist as `mailermine/mailermine`
5. Run customer install verification (fresh Laravel + `composer require`)
6. Publish website docs from `docs/website/README.md`

Checklist: [RELEASE_CHECKLIST.md](RELEASE_CHECKLIST.md)

---

## Verdict

**Release v1.0.0.** Ready for GitHub, Packagist, and production use by Laravel
developers.
