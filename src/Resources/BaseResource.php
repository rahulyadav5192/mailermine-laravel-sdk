<?php

declare(strict_types=1);

namespace MailerMine\Resources;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use JsonException;
use MailerMine\Client;
use MailerMine\Exceptions\ApiException;
use MailerMine\Exceptions\ExceptionFactory;
use MailerMine\Support\Collection;
use MailerMine\Support\Response;
use OpenAPI\Client\ApiException as GeneratedApiException;
use OpenAPI\Client\Configuration as GeneratedConfiguration;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Base resource. Each concrete resource wraps exactly one generated API class.
 */
abstract class BaseResource
{
    public function __construct(
        protected readonly Client $client,
    ) {}

    protected function generatedConfiguration(): GeneratedConfiguration
    {
        return $this->client->generatedConfiguration();
    }

    protected function httpClient(): ClientInterface
    {
        return $this->client->httpClient();
    }

    /**
     * Execute a generated API call and map exceptions into SDK exceptions.
     *
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T
     */
    protected function request(callable $callback): mixed
    {
        try {
            return $callback();
        } catch (GeneratedApiException $exception) {
            throw ExceptionFactory::fromGenerated($exception);
        }
    }

    /**
     * Execute a call and wrap the result in a Response.
     *
     * @param  callable(): mixed  $callback
     */
    protected function respond(callable $callback): Response
    {
        return Response::from($this->request($callback));
    }

    /**
     * Execute a generated `*WithHttpInfo` call so declared non-2xx responses
     * are consistently converted to SDK exceptions.
     *
     * @param  callable(): array{0: mixed, 1: int, 2: array<string, mixed>}  $callback
     */
    protected function respondWithHttpInfo(callable $callback): Response
    {
        $result = $this->request($callback);
        [$body, $statusCode, $headers] = $result;

        if ($statusCode < 200 || $statusCode > 299) {
            $exception = new GeneratedApiException(
                sprintf('API request failed with status %d.', $statusCode),
                $statusCode,
                $headers,
            );
            $exception->setResponseObject($body);

            throw ExceptionFactory::fromGenerated($exception);
        }

        return Response::from($body);
    }

    /**
     * Execute a list call and wrap the result in a Collection.
     *
     * @param  callable(): mixed  $callback
     */
    protected function collect(callable $callback): Collection
    {
        return $this->respond($callback)->collect();
    }

    /**
     * Execute a generated `*WithHttpInfo` list call and return a collection.
     *
     * @param  callable(): array{0: mixed, 1: int, 2: array<string, mixed>}  $callback
     */
    protected function collectWithHttpInfo(callable $callback): Collection
    {
        return $this->respondWithHttpInfo($callback)->collect();
    }

    /**
     * Send a request built by a generated API class and normalize its raw JSON.
     *
     * This avoids exposing generated response models and shields consumers from
     * generator deserialization issues while retaining generated routes, auth,
     * headers, and request serialization.
     */
    protected function executeRequest(RequestInterface $request): Response
    {
        try {
            $response = $this->httpClient()->send($request, ['http_errors' => false]);
        } catch (RequestException $exception) {
            if ($exception->getResponse() instanceof ResponseInterface) {
                return $this->normalizeHttpResponse($exception->getResponse());
            }

            throw new ApiException(
                message: 'Unable to connect to the MailerMine API.',
                previous: $exception,
            );
        } catch (GuzzleException $exception) {
            throw new ApiException(
                message: 'Unable to connect to the MailerMine API.',
                previous: $exception,
            );
        }

        return $this->normalizeHttpResponse($response);
    }

    protected function executeCollectionRequest(RequestInterface $request): Collection
    {
        return $this->executeRequest($request)->collect();
    }

    /**
     * Send a request that returns a non-JSON payload (for example CSV).
     */
    protected function executeRawRequest(RequestInterface $request): Response
    {
        try {
            $response = $this->httpClient()->send($request, ['http_errors' => false]);
        } catch (RequestException $exception) {
            if ($exception->getResponse() instanceof ResponseInterface) {
                return $this->normalizeRawHttpResponse($exception->getResponse());
            }

            throw new ApiException(
                message: 'Unable to connect to the MailerMine API.',
                previous: $exception,
            );
        } catch (GuzzleException $exception) {
            throw new ApiException(
                message: 'Unable to connect to the MailerMine API.',
                previous: $exception,
            );
        }

        return $this->normalizeRawHttpResponse($response);
    }

    private function normalizeHttpResponse(ResponseInterface $response): Response
    {
        $rawBody = (string) $response->getBody();

        try {
            $body = $rawBody === '' ? null : json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new ApiException(
                message: 'MailerMine returned an invalid JSON response.',
                statusCode: $response->getStatusCode(),
                responseBody: $rawBody,
                headers: $response->getHeaders(),
                previous: $exception,
            );
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            $exception = new GeneratedApiException(
                sprintf('API request failed with status %d.', $statusCode),
                $statusCode,
                $response->getHeaders(),
                $body,
            );
            $exception->setResponseObject($body);

            throw ExceptionFactory::fromGenerated($exception);
        }

        return Response::from($body);
    }

    private function normalizeRawHttpResponse(ResponseInterface $response): Response
    {
        $rawBody = (string) $response->getBody();
        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            $decoded = null;

            try {
                $decoded = $rawBody === '' ? null : json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                // Non-JSON error body (for example an HTML error page): surface it raw.
                $decoded = ['message' => $rawBody];
            }

            $exception = new GeneratedApiException(
                sprintf('API request failed with status %d.', $statusCode),
                $statusCode,
                $response->getHeaders(),
                $decoded,
            );
            $exception->setResponseObject($decoded);

            throw ExceptionFactory::fromGenerated($exception);
        }

        return Response::from([
            'success' => true,
            'message' => 'OK',
            'data' => $rawBody,
        ]);
    }
}
