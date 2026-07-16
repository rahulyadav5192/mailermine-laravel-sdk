<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

/**
 * Thrown when the API key is missing, invalid, or unauthorized (HTTP 401).
 */
final class AuthenticationException extends ApiException {}
