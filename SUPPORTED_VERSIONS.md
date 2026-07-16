# Supported Versions

This document describes which versions of the MailerMine PHP & Laravel SDK
receive updates, and the PHP and Laravel versions they support.

## SDK release support

| Version | Status              | Bug fixes | Security fixes |
| ------- | ------------------- | :-------: | :------------: |
| 1.x     | Active              |    Yes    |      Yes       |

Only the latest minor release of each active major line receives fixes. We
follow [Semantic Versioning](https://semver.org).

## Runtime requirements

| SDK version | PHP           | Laravel        |
| ----------- | ------------- | -------------- |
| 1.x         | 8.3, 8.4      | 12.x, 13.x     |

> The SDK works in **any** PHP 8.3+ project. Laravel is optional — the framework
> integration (service provider, facade, config) is only loaded when Laravel is
> present.

## Extensions

The following PHP extensions are required:

- `ext-curl`
- `ext-json`
- `ext-mbstring`

## Upgrade guidance

See [UPGRADE.md](UPGRADE.md) for version-to-version upgrade instructions.
