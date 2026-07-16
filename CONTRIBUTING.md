# Contributing

Thanks for your interest in improving the MailerMine PHP & Laravel SDK! This
document explains how to set up your environment and the standards we hold code
to.

## Code of Conduct

This project is released with a [Code of Conduct](CODE_OF_CONDUCT.md). By
participating you agree to abide by its terms.

## Important: the `generated/` directory

The `generated/` directory contains the OpenAPI-generated client and is **not**
edited by hand. It is regenerated from the MailerMine OpenAPI specification. Pull
requests that modify files under `generated/` will not be accepted. All SDK
behaviour lives in the handwritten wrappers under `src/`.

## Getting started

```bash
git clone https://github.com/rahulyadav5192/mailermine-laravel-sdk.git
cd mailermine-laravel-sdk
composer install
```

## Development workflow

We provide Composer scripts for the full quality pipeline:

```bash
composer test        # Run the PHPUnit test suite
composer test:lint   # Check code style (Laravel Pint)
composer lint        # Fix code style
composer analyse     # Run PHPStan static analysis (level 8)
composer check       # Run style, static analysis, and tests together
```

Before opening a pull request, make sure `composer check` passes.

## Standards

- **Code style:** [Laravel Pint](https://laravel.com/docs/pint) using the config
  in `pint.json`. Run `composer lint` to auto-fix.
- **Static analysis:** [PHPStan](https://phpstan.org) at level 8 with
  [Larastan](https://github.com/larastan/larastan). Fix issues at the source
  rather than adding ignores.
- **Tests:** New features and bug fixes must include tests. API calls are mocked;
  see `tests/Feature/MocksMailerMineApi.php`.
- **Types:** Public methods must have complete type declarations and PHPDoc,
  including `@param`, `@return`, `@throws`, and an `@example` where useful.
- **Backwards compatibility:** Follow [Semantic Versioning](https://semver.org).
  Avoid breaking public APIs outside of a major release.

## Commit messages & pull requests

- Write clear, descriptive commit messages.
- Reference related issues (for example `Fixes #123`).
- Keep pull requests focused on a single change.
- Fill out the pull request template and ensure CI is green.

## Reporting bugs & requesting features

Use the [issue templates](https://github.com/rahulyadav5192/mailermine-laravel-sdk/issues/new/choose).
For security issues, please follow the [security policy](SECURITY.md) instead of
opening a public issue.
