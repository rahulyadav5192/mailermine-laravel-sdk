# Upgrade Guide

This guide documents notable changes between releases and the steps required to
upgrade. The SDK follows [Semantic Versioning](https://semver.org): breaking
changes only occur in major releases.

## Upgrading to 1.0

This is the first public release. No upgrade steps are required.

### Installation

```bash
composer require mailermine/mailermine
```

### Laravel

The service provider and `MailerMine` facade are auto-discovered. Publish the
config file if you want to customise it:

```bash
php artisan vendor:publish --tag=mailermine-config
```

Set your credentials in `.env`:

```dotenv
MAILERMINE_API_KEY=your-api-key
MAILERMINE_BASE_URL=https://mailermine.com/api/v1
```

---

## General upgrade tips

- Read the [CHANGELOG](CHANGELOG.md) for the full list of changes.
- Run your test suite after upgrading.
- Run `composer update mailermine/mailermine` to pull the latest release within
  your allowed version constraint.
- The `generated/` OpenAPI client is an internal implementation detail. Never
  reference `OpenAPI\Client\*` classes directly — always use the `MailerMine\*`
  public API so upgrades remain non-breaking.
