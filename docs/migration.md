# Migration Guide

## Migrating to v1.0.0

v1.0.0 is the first public release. There is no prior stable SDK version to
migrate from.

### Fresh install

```bash
composer require mailermine/mailermine
```

Laravel:

```bash
php artisan vendor:publish --tag=mailermine-config
```

```dotenv
MAILERMINE_API_KEY=your-api-key
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
```

### If you used early development builds

1. Update Composer:

   ```bash
   composer require mailermine/mailermine:^1.0
   ```

2. Replace any direct `OpenAPI\Client\*` usage with the public `MailerMine\*`
   API. Generated classes are an internal implementation detail and may change
   without notice.

3. Prefer `Response::data()`, `Collection`, and typed exceptions
   (`AuthenticationException`, `PlanException`, `ValidationException`, etc.) over
   raw HTTP clients.

4. If you previously caught `AuthenticationException` for HTTP 403 plan or
   feature restrictions, catch `MailerMine\Exceptions\PlanException` instead.
   `AuthenticationException` now maps to HTTP 401 (invalid API key) only.

5. Confirm your `MAILERMINE_BASE_URL` includes `/api/v1`.

### Future major versions

Breaking changes will only land in major releases (2.0, 3.0, …). See
[UPGRADE.md](../UPGRADE.md) and [CHANGELOG.md](../CHANGELOG.md) for
version-to-version notes.
