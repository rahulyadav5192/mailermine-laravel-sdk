<?php

declare(strict_types=1);

namespace MailerMine\Exceptions;

/**
 * Thrown when the current plan or account permissions do not allow an action (HTTP 403).
 *
 * The MailerMine API returns 403 when a feature is not included in your plan,
 * an account is suspended, or a project-scoped key is used across projects.
 * This is distinct from {@see AuthenticationException} (HTTP 401), which means
 * the API key itself is missing or invalid.
 *
 * The exception message always includes actionable upgrade guidance, and
 * {@see PlanException::getUpgradeUrl()} returns the billing URL you can redirect
 * users to.
 *
 * @example
 * use MailerMine\Exceptions\PlanException;
 *
 * try {
 *     MailerMine::emails()->send([...]);
 * } catch (PlanException $e) {
 *     // Prompt the account owner to upgrade.
 *     return redirect()->away($e->getUpgradeUrl())
 *         ->with('error', $e->getMessage());
 * }
 */
final class PlanException extends ApiException
{
    /**
     * URL where the account owner can review or upgrade their plan.
     */
    public const UPGRADE_URL = 'https://mailermine.com/billing';

    /**
     * The billing URL where the current plan can be reviewed or upgraded.
     */
    public function getUpgradeUrl(): string
    {
        return self::UPGRADE_URL;
    }
}
