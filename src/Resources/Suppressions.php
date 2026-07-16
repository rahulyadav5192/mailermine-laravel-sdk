<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\NotFoundException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\SuppressionsApi;
use OpenAPI\Client\Model\CreateSuppressionRequest;

/**
 * Suppressions resource.
 *
 * Manage suppressed recipient addresses.
 *
 * @example
 * $mm->suppressions()->add([
 *     'email' => 'john@example.com',
 *     'reason' => 'manual',
 * ]);
 *
 * $check = $mm->suppressions()->check('john@example.com');
 */
final class Suppressions extends BaseResource
{
    private ?SuppressionsApi $api = null;

    /**
     * List suppressions with filters.
     *
     * @param array{
     *     search?: string,
     *     reason?: string,
     *     per_page?: int
     * } $filters Suppression list filters.
     * @return Collection A collection of suppressions with pagination metadata when present.
     *
     * @throws ApiException When suppressions cannot be listed.
     *
     * @example
     * $suppressions = $mm->suppressions()->list(['reason' => 'bounce']);
     */
    public function list(array $filters = []): Collection
    {
        return $this->executeCollectionRequest($this->api()->listSuppressionsRequest(
            $filters['search'] ?? null,
            $filters['reason'] ?? null,
            isset($filters['per_page']) ? (int) $filters['per_page'] : null,
        ));
    }

    /**
     * Retrieve a suppression by UUID.
     *
     * MailerMine does not expose a dedicated get endpoint, so this helper
     * searches the suppression list and matches by id.
     *
     * @param  string  $suppressionId  Suppression UUID.
     * @return Response The matched suppression.
     *
     * @throws NotFoundException When no suppression matches the id.
     * @throws ApiException When suppressions cannot be listed.
     *
     * @example
     * $suppression = $mm->suppressions()->get($suppressionId);
     */
    public function get(string $suppressionId): Response
    {
        $matches = $this->list(['search' => $suppressionId, 'per_page' => 100]);

        foreach ($matches as $item) {
            if (is_array($item) && ($item['id'] ?? null) === $suppressionId) {
                return Response::from([
                    'success' => true,
                    'message' => 'OK',
                    'data' => $item,
                ]);
            }
        }

        throw new NotFoundException(
            message: sprintf('Suppression [%s] was not found.', $suppressionId),
            statusCode: 404,
        );
    }

    /**
     * Add an email to the suppression list.
     *
     * @param array{
     *     email: string,
     *     reason: string,
     *     notes?: string|null
     * } $parameters Suppression attributes. Reason is one of bounce, complaint,
     *        manual, or unsubscribe.
     * @return Response The created suppression.
     *
     * @throws ApiException When the suppression cannot be created.
     *
     * @example
     * $suppression = $mm->suppressions()->add([
     *     'email' => 'john@example.com',
     *     'reason' => 'manual',
     * ]);
     */
    public function add(array $parameters): Response
    {
        $request = RequestBuilder::make(CreateSuppressionRequest::class, $parameters);

        return $this->executeRequest($this->api()->createSuppressionRequest($request));
    }

    /**
     * Remove a suppression by UUID.
     *
     * @param  string  $suppressionId  Suppression UUID.
     * @return Response Deletion confirmation.
     *
     * @throws ApiException When the suppression cannot be removed.
     *
     * @example
     * $mm->suppressions()->remove($suppressionId);
     */
    public function remove(string $suppressionId): Response
    {
        return $this->executeRequest($this->api()->deleteSuppressionRequest($suppressionId));
    }

    /**
     * Restore a previously removed or soft-deleted suppression.
     *
     * @param  string  $suppressionId  Suppression UUID.
     * @return Response The restored suppression.
     *
     * @throws ApiException When the suppression cannot be restored.
     *
     * @example
     * $mm->suppressions()->restore($suppressionId);
     */
    public function restore(string $suppressionId): Response
    {
        return $this->executeRequest($this->api()->restoreSuppressionRequest($suppressionId));
    }

    /**
     * Check whether an email address is suppressed.
     *
     * Uses the suppression search endpoint and matches exact email addresses.
     * Results are limited by API pagination.
     *
     * @param  string  $email  Email address to check.
     * @return Response Check result with `suppressed` and optional `suppression`.
     *
     * @throws ApiException When suppressions cannot be searched.
     *
     * @example
     * $check = $mm->suppressions()->check('john@example.com');
     * if ($check->data()['suppressed']) {
     *     // Skip sending.
     * }
     */
    public function check(string $email): Response
    {
        $email = strtolower(trim($email));

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('A valid email address is required.');
        }

        $matches = $this->list(['search' => $email, 'per_page' => 100]);
        $match = null;

        foreach ($matches as $item) {
            if (!is_array($item)) {
                continue;
            }

            $candidate = strtolower((string) ($item['email'] ?? ''));

            if ($candidate === $email) {
                $match = $item;
                break;
            }
        }

        return Response::from([
            'success' => true,
            'message' => 'OK',
            'data' => [
                'email' => $email,
                'suppressed' => $match !== null,
                'suppression' => $match,
            ],
        ]);
    }

    private function api(): SuppressionsApi
    {
        return $this->api ??= new SuppressionsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
