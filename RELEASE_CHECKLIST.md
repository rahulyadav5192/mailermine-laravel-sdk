# Release Checklist — v1.0.0

Use this checklist before publishing `mailermine/mailermine` to Packagist.

## Pre-flight

- [ ] `composer validate --strict` passes
- [ ] `composer audit` reports no advisories
- [ ] `composer test` passes (PHPUnit)
- [ ] `composer test:lint` passes (Pint)
- [ ] `composer analyse` passes (PHPStan level 8)
- [ ] Example files lint with `php -l examples/*.php`
- [ ] `generated/` was **not** hand-edited
- [ ] README, LICENSE, CHANGELOG, CONTRIBUTING, SECURITY, CODE_OF_CONDUCT present
- [ ] Issue / PR templates present under `.github/`
- [ ] CI workflow covers PHP 8.3/8.4 × Laravel 12/13
- [ ] `docs/` guides published
- [ ] Package name is `mailermine/mailermine`
- [ ] Laravel auto-discovery configured in `extra.laravel`
- [ ] Support URLs in `composer.json` match the public GitHub repository

## GitHub

- [ ] All release files committed on `main`
- [ ] Tag created: `v1.0.0`
- [ ] Tag pushed: `git push origin v1.0.0`
- [ ] GitHub Release published with notes from `.github/release/v1.0.0.md`
- [ ] Discussions enabled (see `.github/DISCUSSION_CATEGORIES.md`)

## Packagist

1. Sign in at [packagist.org](https://packagist.org).
2. Submit the GitHub repository URL.
3. Confirm the package name resolves as `mailermine/mailermine`.
4. Enable GitHub Service Hook / auto-update so new tags sync automatically.
5. Verify: `composer require mailermine/mailermine:^1.0` works in a fresh project.

## Customer install verification (post-Packagist)

```bash
composer create-project laravel/laravel mailermine-sdk-smoke
cd mailermine-sdk-smoke
composer require mailermine/mailermine
```

Then configure `MAILERMINE_API_KEY` and run through:

- [ ] Send email
- [ ] Verify domain
- [ ] Create template
- [ ] Create contact
- [ ] Create campaign
- [ ] Read analytics
- [ ] Configure webhook

Script: [`examples/customer-smoke.php`](../examples/customer-smoke.php) (optional helper).

## Website

- [ ] Publish Official Laravel SDK page using `docs/website/README.md`
- [ ] Link GitHub + Packagist + version support + release notes

## Announce

- [ ] Update mailermine.com docs
- [ ] GitHub Discussion announcement
- [ ] Internal changelog / changelog entry for Unreleased → 1.0.0
