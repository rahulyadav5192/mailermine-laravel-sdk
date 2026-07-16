<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\ExportsApi;
use OpenAPI\Client\Model\ExportContactsRequest;

/**
 * Exports resource.
 *
 * Wraps {@see ExportsApi}.
 */
final class Exports extends BaseResource
{
    private ?ExportsApi $api = null;

    /**
     * Queue a contact export.
     *
     * @param array{
     *     search?: string,
     *     status?: string,
     *     subscribed?: bool|string|int,
     *     list?: string,
     *     tag_name?: string,
     *     ids?: list<string>
     * } $parameters Optional export filters.
     * @return Response The queued export job.
     *
     * @throws ApiException When the export cannot be queued.
     *
     * @example
     * $export = $mm->exports()->create([
     *     'status' => 'active',
     *     'subscribed' => true,
     * ]);
     */
    public function create(array $parameters = []): Response
    {
        $request = $parameters === []
            ? null
            : RequestBuilder::make(ExportContactsRequest::class, $parameters);

        return $this->executeRequest($this->api()->exportContactsRequest($request));
    }

    /**
     * Retrieve export job status.
     *
     * @param  string  $exportId  Export job UUID.
     * @return Response The export job payload, including download metadata.
     *
     * @throws ApiException When the export cannot be retrieved.
     *
     * @example
     * $status = $mm->exports()->status($exportId);
     * echo $status->data()['status'];
     */
    public function status(string $exportId): Response
    {
        return $this->executeRequest($this->api()->getContactExportRequest($exportId));
    }

    /**
     * Download a completed export as CSV content.
     *
     * The CSV payload is available from `$response->data()`.
     *
     * @param  string  $exportId  Export job UUID.
     * @return Response A response whose data is the raw CSV string.
     *
     * @throws ApiException When the export cannot be downloaded.
     *
     * @example
     * $csv = $mm->exports()->download($exportId);
     * file_put_contents('contacts.csv', $csv->data());
     */
    public function download(string $exportId): Response
    {
        return $this->executeRawRequest(
            $this->api()->downloadContactExportRequest($exportId)
        );
    }

    private function api(): ExportsApi
    {
        return $this->api ??= new ExportsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
