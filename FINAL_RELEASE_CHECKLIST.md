# Final Release Checklist — `mailermine/mailermine` v1.0.0

The single source of truth for shipping v1.0.0 to Packagist. Every item marked
**BLOCKER** must be resolved before publishing. Items are ordered in the sequence
they should be performed.

Legend: ✅ done · ⬜ pending action · **BLOCKER** = must complete before publish.

---

## 1. Code quality gates (all green locally)

| Check | Command | Status |
| ----- | ------- | ------ |
| Unit + feature tests (77) | `composer test` | ✅ |
| Static analysis (PHPStan level 8) | `composer test:types` | ✅ |
| Code style (Pint) | `composer test:lint` | ✅ |
| Composer manifest | `composer validate --strict` | ✅ |
| Dependency audit | `composer audit` | ⬜ run on the release commit |

Run everything at once before tagging:

```bash
composer check && composer audit
```

## 2. Developer-experience review (this release)

- ✅ HTTP 403 now raises a dedicated `PlanException` (feature/plan restriction)
  instead of `AuthenticationException`; message includes upgrade guidance and
  `getUpgradeUrl()`.
- ✅ `AuthenticationException` is HTTP 401 only.
- ✅ Generated OpenAPI exceptions are never exposed — construction and validation
  failures are converted to `ValidationException`; transport/API failures go
  through `ExceptionFactory`.
- ✅ Client-side request validation runs before a request is sent (friendly,
  per-field `ValidationException`).
- ✅ Global `mailermine()` helper resolves the shared client from the container.
- ✅ `ApiException::getRequestId()` added for support correlation.
- ✅ Every public method has a PHPDoc block; resource methods include `@example`.
- ✅ `Response`, `Collection`, and `Pagination` reviewed for consistency.
- ✅ Resource method naming reviewed (`create`/`list`/`get`/`update`/`delete`
  consistent across resources).
- ✅ README Quick Start ordering: Facade → `mailermine()` helper → dependency
  injection → raw client.

## 3. Repository assets (verify present & current)

- ✅ `README.md`, `LICENSE`, `CHANGELOG.md` (1.0.0 entry current)
- ✅ `CONTRIBUTING.md`, `SECURITY.md`, `CODE_OF_CONDUCT.md`
- ✅ `ROADMAP.md`, `SUPPORTED_VERSIONS.md`, `UPGRADE.md`
- ✅ `docs/` guide set (installation, quick-start, authentication, transactional,
  domains, templates, contacts, campaigns, analytics, webhooks, faq,
  troubleshooting, migration)
- ✅ `.github/` issue templates, PR template, discussions guide, CI workflow,
  Dependabot
- ⬜ Confirm all GitHub URLs point to the correct repo
  (`rahulyadav5192/mailermine-laravel-sdk`).

## 4. Commit & re-tag — **BLOCKER**

> The existing local `v1.0.0` tag was created **before** the developer-experience
> changes in this release. It must be recreated so the tag includes them.

```bash
# 1. Stage and commit the DX release changes
git add -A
git commit -m "Prepare v1.0.0: PlanException, client-side validation, mailermine() helper, docs"

# 2. Move the tag to the release commit (delete stale local + remote tag first)
git tag -d v1.0.0
git push origin :refs/tags/v1.0.0   # only if the tag was already pushed
git tag -a v1.0.0 -m "v1.0.0"

# 3. Verify the tag points at HEAD
git rev-parse v1.0.0 HEAD           # both hashes must match
```

- ⬜ **BLOCKER**: `v1.0.0` tag points at the commit containing these changes.
- ⬜ **BLOCKER**: `Client::VERSION` (`1.0.0`) matches the tag.

## 5. Push to GitHub — **BLOCKER**

```bash
git push origin main
git push origin v1.0.0
```

- ⬜ **BLOCKER**: `main` and `v1.0.0` are pushed to GitHub.
- ⬜ **BLOCKER**: CI is green on the pushed commit (tests, style, static
  analysis, composer validate/audit, docs, install smoke test).

## 6. GitHub Release — **BLOCKER**

```bash
gh release create v1.0.0 \
  --title "v1.0.0" \
  --notes-file .github/release/v1.0.0.md
```

- ⬜ **BLOCKER**: Release published from the `v1.0.0` tag with notes.

## 7. Publish to Packagist — **BLOCKER**

- ⬜ **BLOCKER**: Submit `https://github.com/rahulyadav5192/mailermine-laravel-sdk`
  on <https://packagist.org/packages/submit> as `mailermine/mailermine`.
- ⬜ **BLOCKER**: Enable the Packagist ↔ GitHub webhook (auto-update on push).
- ⬜ Confirm the package page shows version `1.0.0` and PHP `^8.3`.

## 8. Post-publish install verification — **BLOCKER**

Install exactly as a customer would (no local path repository):

```bash
./scripts/customer-install-test.sh
```

Then, in a scratch Laravel app with a real `MAILERMINE_API_KEY`:

- ⬜ `composer require mailermine/mailermine` resolves from Packagist.
- ⬜ Service provider + facade auto-discovered (`php artisan package:discover`).
- ⬜ `mailermine()` helper is available.
- ⬜ Send a transactional email end-to-end.
- ⬜ Create/verify a domain, create a template, create a contact, create a
  campaign, read analytics, configure a webhook.

## 9. Compatibility matrix (CI-verified)

- ⬜ PHP 8.3 and 8.4.
- ⬜ Laravel 12 and 13.

## 10. Website & announcement (non-blocking)

- ⬜ Publish SDK docs on mailermine.com (see `docs/website/`).
- ⬜ Link GitHub + Packagist from the docs site.
- ⬜ Announce in GitHub Discussions.

---

## Remaining blockers summary

1. Commit the DX changes and **recreate the `v1.0.0` tag** on that commit.
2. Push `main` + `v1.0.0`; confirm **CI is green**.
3. Create the **GitHub Release**.
4. **Submit to Packagist** and enable the auto-update webhook.
5. Run the **customer install smoke test** against Packagist with a live API key.

Everything else (code quality, exceptions, validation, helper, docs, examples,
templates) is complete.
