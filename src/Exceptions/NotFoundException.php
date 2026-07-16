<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

/**
 * Thrown when the requested API resource does not exist (HTTP 404).
 */
final class NotFoundException extends ApiException {}
