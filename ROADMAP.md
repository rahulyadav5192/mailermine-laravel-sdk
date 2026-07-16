# Roadmap

This roadmap communicates the direction of the MailerMine PHP & Laravel SDK. It
is aspirational, not a commitment, and priorities may shift based on community
feedback. Have an idea? Open a
[discussion](https://github.com/rahulyadav5192/mailermine-laravel-sdk/discussions).

## Guiding principles

- **Stability first.** The public API stays backwards compatible within a major
  version.
- **Laravel-native feel.** The SDK should feel like a first-party Laravel package.
- **Great developer experience.** Full IDE autocomplete, typed responses, and
  runnable examples.
- **The generated client stays internal.** `generated/` is regenerated from the
  OpenAPI spec and never leaks into the public API.

## Now (1.x)

- Complete coverage of the MailerMine public API.
- PHPStan level 8 and Laravel Pint enforced in CI.
- Comprehensive README and runnable examples.

## Next

- Optional automatic retries with exponential backoff for transient failures.
- Idempotency-key helpers for safe retries on write operations.
- Typed data objects for common response payloads.
- Response caching helpers for analytics endpoints.

## Later

- Async / concurrent request helpers.
- Laravel notification channel for transactional email.
- Artisan commands for common tasks (send test email, verify domain).
- First-class pagination iterators (`each`, `lazy`).

## Under consideration

- Symfony bundle.
- PSR-18 HTTP client injection at the public API layer.

See [SUPPORTED_VERSIONS.md](SUPPORTED_VERSIONS.md) for supported PHP and Laravel
versions.
