# Changelog

All notable changes to `mailermine/mailermine` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2026-11-17

### Added

- Automatic retries with exponential backoff and jitter for rate-limited
  (429) and temporarily unavailable (502/503/504) responses and connection
  failures, honouring `Retry-After`. Configure with `max_retries` (default 2)
  and `max_retry_delay` (default 30s); `MAILERMINE_MAX_RETRIES=0` disables.
- `emails()->send()` sends an `Idempotency-Key` automatically so retries never
  deliver twice; pass `['idempotency_key' => '...']` to control it.
- `Response::rateLimit()`, `headers()`, `header()` and `wasIdempotentReplay()`;
  `ApiException::rateLimit()` and `isRetryable()`.
- `MissingScopeException` (HTTP 403 with `errors.scope`) with
  `getMissingScopes()`. Plan restrictions still raise `PlanException`.
- `MailerMine\Support\Scope` constants and presets (`SENDING_ONLY`, ...),
  including the new `webhooks.*`, `suppressions.*` and `events.read` scopes.
- `Webhooks::verifyHeaders()` reads the signature and timestamp headers.
- `suppressions` GET-by-id support in the regenerated client.

### Fixed

- `Webhooks::verify()` could never validate a real MailerMine webhook: the
  server signs `{timestamp}.{body}`, but the SDK only hashed the body. Pass the
  `X-MailerMine-Timestamp` value (or use `verifyHeaders()`); timestamps older
  than 5 minutes are rejected. Calls without a timestamp keep the old
  body-only check.
- Creating API keys with the new scopes no longer fails client-side.
- Updating a segment no longer requires sending `rules`.

### Changed

- Regenerated the OpenAPI client from the current API spec.
- A 403 for a missing scope is now `MissingScopeException` instead of
  `PlanException` (both extend `ApiException`).
- Connect timeout is capped at 10 seconds (overall timeout unchanged).

## [1.0.0] - 2026-07-17

Initial public release of the MailerMine PHP & Laravel SDK.

### Added

- Transactional email sending with attachments, CC/BCC, and template support.
- Domain management, DNS record inspection, and verification helpers.
- Template create, list, update, delete, and render helpers.
- Contacts, Lists, Audiences, Segments, and Tags for audience management.
- Contact imports (CSV/multipart) and exports with download streaming.
- Campaigns: create, schedule, send, lifecycle, recipients, content, analytics,
  and events.
- Platform analytics: overview, deliveries, opens, clicks, bounces, complaints,
  unsubscribes, usage, and activity with date-range and entity filters.
- Message events and delivery logs.
- Webhooks: CRUD, secret rotation, deliveries, failures, and event replay, plus
  `Webhooks::verify()` for HMAC-SHA256 signature verification.
- Suppression list management.
- First-class Laravel integration: auto-discovered service provider, `MailerMine`
  facade, publishable configuration, and a global `mailermine()` helper that
  resolves the shared client from the container.
- Typed exceptions (`AuthenticationException`, `PlanException`,
  `NotFoundException`, `ValidationException`, `RateLimitException`,
  `ApiException`). Plan and feature restrictions (HTTP 403) raise a dedicated
  `PlanException` with actionable upgrade guidance and `getUpgradeUrl()`, and are
  no longer conflated with authentication failures (HTTP 401).
- Client-side request validation: invalid payloads raise a friendly
  `ValidationException` before a request is sent, and generated OpenAPI
  exceptions are always converted into SDK exceptions.
- `ApiException::getRequestId()` for correlating failures with support.
- `Response`, `Collection`, and `Pagination` value objects for ergonomic access.

[Unreleased]: https://github.com/rahulyadav5192/mailermine-laravel-sdk/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/rahulyadav5192/mailermine-laravel-sdk/releases/tag/v1.0.0

