<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

/**
 * Thrown when the API key is missing or invalid (HTTP 401).
 *
 * For plan or feature restrictions (HTTP 403) catch {@see PlanException} instead.
 *
 * @example
 * use MailerMine\Exceptions\AuthenticationException;
 *
 * try {
 *     MailerMine::emails()->send([...]);
 * } catch (AuthenticationException $e) {
 *     // The MAILERMINE_API_KEY is missing or incorrect.
 *     report($e);
 * }
 */
final class AuthenticationException extends ApiException {}
