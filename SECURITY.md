# Security Policy

We take the security of the MailerMine SDK and our users' data seriously.

## Supported Versions

Security fixes are provided for the versions listed in
[SUPPORTED_VERSIONS.md](SUPPORTED_VERSIONS.md). Please make sure you are running a
supported release before reporting an issue.

## Reporting a Vulnerability

**Please do not report security vulnerabilities through public GitHub issues,
discussions, or pull requests.**

Instead, report them privately using one of the following channels:

- Email: [security@mailermine.com](mailto:security@mailermine.com)
- GitHub: use the **"Report a vulnerability"** button under the repository's
  [Security Advisories](https://github.com/rahulyadav5192/mailermine-laravel-sdk/security/advisories/new)
  tab.

Please include as much of the following as possible:

- A description of the vulnerability and its impact.
- Steps to reproduce or a proof of concept.
- Affected version(s) of the SDK.
- Any suggested remediation.

## What to Expect

- We will acknowledge your report within **3 business days**.
- We will provide an assessment and expected timeline within **7 business days**.
- We will keep you informed as we work on a fix.
- We will credit you in the release notes unless you prefer to remain anonymous.

## Handling API Keys

Never commit API keys to source control. Store them in environment variables
(for example `MAILERMINE_API_KEY`) and rotate them immediately if you suspect
exposure. See the [README](README.md#configuration) for configuration guidance.

Thank you for helping keep MailerMine and its users safe.
