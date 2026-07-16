#!/usr/bin/env bash
# Customer-style install verification after Packagist publish.
# Does NOT use a local path repository.
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
WORK="${TMPDIR:-/tmp}/mailermine-sdk-customer-$$"

echo "== Customer install test =="
echo "Workdir: $WORK"

mkdir -p "$WORK"
cd "$WORK"

echo "Creating Laravel project..."
composer create-project laravel/laravel app --prefer-dist --no-interaction

cd app

echo "Installing mailermine/mailermine from Packagist..."
composer require mailermine/mailermine --no-interaction

echo "Publishing config..."
php artisan vendor:publish --tag=mailermine-config --no-interaction

if [[ -z "${MAILERMINE_API_KEY:-}" ]]; then
  echo "MAILERMINE_API_KEY is not set."
  echo "Package installed successfully. Set MAILERMINE_API_KEY and re-run:"
  echo "  php vendor/mailermine/mailermine/examples/customer-smoke.php"
  exit 0
fi

echo "Running customer smoke against live API..."
php vendor/mailermine/mailermine/examples/customer-smoke.php

echo "OK — customer install verified."
