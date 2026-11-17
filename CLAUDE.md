# MailerMine PHP SDK: notes for Claude

This SDK mirrors the MailerMine API defined in `rahulyadav5192/resend`. Any
change that comes from an API change must follow the shared runbook:
**`docs/SDK_SYNC.md` in the resend repo** (https://github.com/rahulyadav5192/resend/blob/main/docs/SDK_SYNC.md).
Keep behaviour identical to `mailermine-node` and `mailermine-sdk-python` (runbook §7).

## Layout
- `generated/`: openapi-generator **7.23.0** (`-g php`) output. Never edit it by hand; regenerate it.
- `openapi.json`: the spec the client was generated from (copy of resend's `public/openapi.json`).
- Hand-written: `src/Resources/*`, `src/Http/HttpStack.php` (retries + idempotency),
  `src/Exceptions/*` (`ExceptionFactory` maps status codes), `src/Support/*`
  (`Response`, `RateLimit`, `Scope`), `src/Resources/Webhooks.php` (signature verification).

## Regenerate
```bash
npx --yes @openapitools/openapi-generator-cli@2 generate -g php -i openapi.json -o /tmp/php-check --skip-validate-spec
diff -rq /tmp/php-check generated | wc -l      # must be 0 before using a new spec
cp ../resend/public/openapi.json openapi.json
npx --yes @openapitools/openapi-generator-cli@2 generate -g php -i openapi.json -o generated --skip-validate-spec
```
(`openapitools.json` must pin `"version": "7.23.0"`.)

## Check
`composer test && composer test:lint && composer analyse`

## Release
Bump `Client::VERSION` and `Configuration::DEFAULT_USER_AGENT`, update `CHANGELOG.md`, then tag.
The resend app installs this package, so bump it there after publishing.
