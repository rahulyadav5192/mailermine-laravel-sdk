<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use InvalidArgumentException;
use MailerMine\Exceptions\ApiException;
use MailerMine\Helpers\RequestBuilder;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\Api\ImportsApi;
use OpenAPI\Client\Model\ConfigureContactImportRequest;
use Psr\Http\Message\RequestInterface;
use SplFileObject;

/**
 * Imports resource.
 *
 * Wraps {@see ImportsApi}.
 */
final class Imports extends BaseResource
{
    private ?ImportsApi $api = null;

    /**
     * Upload a contact import file.
     *
     * Accepts a filesystem path, open resource, or SplFileObject under `file`.
     * After upload, call configure() and start() to process the import.
     *
     * @param  array{file: string|resource|SplFileObject}  $parameters  Import upload payload.
     * @return Response The created import job.
     *
     * @throws ApiException When the upload is rejected.
     *
     * @example
     * $import = $mm->imports()->create([
     *     'file' => __DIR__ . '/contacts.csv',
     * ]);
     */
    public function create(array $parameters): Response
    {
        return $this->executeRequest($this->buildUploadRequest($parameters));
    }

    /**
     * Configure field mappings and import options.
     *
     * @param  string  $importId  Import job UUID.
     * @param array{
     *     field_mappings: array<string, mixed>,
     *     duplicate_strategy?: string,
     *     default_status?: string,
     *     import_source?: string,
     *     timezone?: string,
     *     country?: string,
     *     double_opt_in?: bool,
     *     tag_separator?: string,
     *     create_missing_tags?: bool,
     *     audience_mode?: string,
     *     audience_uuid?: string,
     *     create_missing_audiences?: bool,
     *     new_properties?: array<string, mixed>
     * } $parameters Import configuration.
     * @return Response The configured import job.
     *
     * @throws ApiException When configuration is rejected.
     *
     * @example
     * $mm->imports()->configure($importId, [
     *     'field_mappings' => ['email' => 'Email'],
     *     'duplicate_strategy' => 'update',
     * ]);
     */
    public function configure(string $importId, array $parameters): Response
    {
        $request = RequestBuilder::make(ConfigureContactImportRequest::class, $parameters);

        return $this->executeRequest(
            $this->api()->configureContactImportRequest($importId, $request)
        );
    }

    /**
     * Start processing a configured import.
     *
     * @param  string  $importId  Import job UUID.
     * @return Response The queued import job.
     *
     * @throws ApiException When the import cannot be started.
     *
     * @example
     * $mm->imports()->start($importId);
     */
    public function start(string $importId): Response
    {
        return $this->executeRequest($this->api()->startContactImportRequest($importId));
    }

    /**
     * Retrieve import job status and progress.
     *
     * @param  string  $importId  Import job UUID.
     * @return Response The import job detail payload.
     *
     * @throws ApiException When the import cannot be retrieved.
     *
     * @example
     * $status = $mm->imports()->status($importId);
     * echo $status->data()['status'];
     */
    public function status(string $importId): Response
    {
        return $this->executeRequest($this->api()->getContactImportRequest($importId));
    }

    /**
     * List recent import jobs.
     *
     * @return Collection Recent import jobs.
     *
     * @throws ApiException When the API rejects the request.
     *
     * @example
     * foreach ($mm->imports()->list() as $import) {
     *     echo $import['status'];
     * }
     */
    public function list(): Collection
    {
        return $this->executeCollectionRequest($this->api()->listContactImportsRequest());
    }

    /**
     * Cancel an import job.
     *
     * MailerMine does not currently expose an import cancellation endpoint, so
     * this method always throws.
     *
     * @param  string  $importId  Import job UUID.
     * @return Response Never returns successfully.
     *
     * @throws ApiException Always, because cancellation is unsupported.
     *
     * @example
     * // Not supported by the current MailerMine API.
     * $mm->imports()->cancel($importId);
     */
    public function cancel(string $importId): Response
    {
        throw new ApiException(
            message: sprintf(
                'MailerMine does not support cancelling import [%s]. Poll status() instead.',
                $importId
            ),
            statusCode: 405,
        );
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    private function buildUploadRequest(array $parameters): RequestInterface
    {
        $file = $parameters['file'] ?? null;

        if ($file === null) {
            throw new InvalidArgumentException('The file field is required.');
        }

        [$contents, $filename] = $this->normalizeUploadFile($file);
        $boundary = 'mailermine-'.bin2hex(random_bytes(16));
        $body = $this->buildMultipartBody($boundary, $contents, $filename);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'multipart/form-data; boundary='.$boundary,
            'User-Agent' => $this->generatedConfiguration()->getUserAgent(),
        ];

        $token = $this->generatedConfiguration()->getAccessToken();

        if ($token !== '') {
            $headers['Authorization'] = 'Bearer '.$token;
        }

        return new \GuzzleHttp\Psr7\Request(
            'POST',
            rtrim($this->generatedConfiguration()->getHost(), '/').'/contacts/import',
            $headers,
            $body,
        );
    }

    /**
     * @param  string|resource|SplFileObject  $file
     * @return array{0: string, 1: string}
     */
    private function normalizeUploadFile(mixed $file): array
    {
        if (is_string($file)) {
            if (!is_file($file) || !is_readable($file)) {
                throw new InvalidArgumentException(sprintf('Unable to read import file [%s].', $file));
            }

            $contents = file_get_contents($file);

            if ($contents === false) {
                throw new InvalidArgumentException(sprintf('Unable to read import file [%s].', $file));
            }

            return [$contents, basename($file)];
        }

        if ($file instanceof SplFileObject) {
            $path = $file->getPathname();
            $contents = file_get_contents($path);

            if ($contents === false) {
                throw new InvalidArgumentException(sprintf('Unable to read import file [%s].', $path));
            }

            return [$contents, $file->getFilename()];
        }

        if (is_resource($file)) {
            $meta = stream_get_meta_data($file);
            $contents = stream_get_contents($file);

            if ($contents === false) {
                throw new InvalidArgumentException('Unable to read import file stream.');
            }

            $uri = is_string($meta['uri'] ?? null) ? $meta['uri'] : 'contacts.csv';

            return [$contents, basename($uri)];
        }

        throw new InvalidArgumentException(
            'The file field must be a path, resource, or SplFileObject.'
        );
    }

    private function buildMultipartBody(string $boundary, string $contents, string $filename): string
    {
        $body = '--'.$boundary."\r\n";
        $body .= 'Content-Disposition: form-data; name="file"; filename="'.addslashes($filename)."\"\r\n";
        $body .= "Content-Type: application/octet-stream\r\n\r\n";
        $body .= $contents."\r\n";
        $body .= '--'.$boundary."--\r\n";

        return $body;
    }

    private function api(): ImportsApi
    {
        return $this->api ??= new ImportsApi(
            $this->httpClient(),
            $this->generatedConfiguration(),
        );
    }
}
