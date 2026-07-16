# OpenAPI\Client\WebhooksApi

Register endpoints, manage subscriptions, and inspect signed event deliveries.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createWebhook()**](WebhooksApi.md#createWebhook) | **POST** /webhooks | Create webhook |
| [**deleteWebhook()**](WebhooksApi.md#deleteWebhook) | **DELETE** /webhooks/{webhook} | Delete webhook |
| [**disableWebhook()**](WebhooksApi.md#disableWebhook) | **POST** /webhooks/{webhook}/disable | Disable webhook |
| [**enableWebhook()**](WebhooksApi.md#enableWebhook) | **POST** /webhooks/{webhook}/enable | Enable webhook |
| [**getWebhook()**](WebhooksApi.md#getWebhook) | **GET** /webhooks/{webhook} | Get webhook |
| [**getWebhookDelivery()**](WebhooksApi.md#getWebhookDelivery) | **GET** /webhook-deliveries/{webhookDelivery} | Get webhook delivery |
| [**listWebhookDeliveries()**](WebhooksApi.md#listWebhookDeliveries) | **GET** /webhooks/{webhook}/deliveries | List webhook deliveries |
| [**listWebhooks()**](WebhooksApi.md#listWebhooks) | **GET** /webhooks | List webhooks |
| [**replayWebhookDeliveries()**](WebhooksApi.md#replayWebhookDeliveries) | **POST** /webhooks/{webhook}/replay | Replay webhook deliveries |
| [**replayWebhookDelivery()**](WebhooksApi.md#replayWebhookDelivery) | **POST** /webhook-deliveries/{webhookDelivery}/replay | Replay webhook delivery |
| [**rotateWebhookSecret()**](WebhooksApi.md#rotateWebhookSecret) | **POST** /webhooks/{webhook}/rotate-secret | Rotate webhook secret |
| [**testWebhook()**](WebhooksApi.md#testWebhook) | **POST** /webhooks/{webhook}/test | Test webhook |
| [**updateWebhook()**](WebhooksApi.md#updateWebhook) | **PATCH** /webhooks/{webhook} | Update webhook |


## `createWebhook()`

```php
createWebhook($create_webhook_request): \OpenAPI\Client\Model\WebhookSecretResponse
```

Create webhook

Register a new webhook endpoint. The signing secret is returned only on creation. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_webhook_request = new \OpenAPI\Client\Model\CreateWebhookRequest(); // \OpenAPI\Client\Model\CreateWebhookRequest

try {
    $result = $apiInstance->createWebhook($create_webhook_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->createWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_webhook_request** | [**\OpenAPI\Client\Model\CreateWebhookRequest**](../Model/CreateWebhookRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\WebhookSecretResponse**](../Model/WebhookSecretResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteWebhook()`

```php
deleteWebhook($webhook): \OpenAPI\Client\Model\DeleteResponse
```

Delete webhook

Permanently delete a webhook endpoint. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.

try {
    $result = $apiInstance->deleteWebhook($webhook);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->deleteWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |

### Return type

[**\OpenAPI\Client\Model\DeleteResponse**](../Model/DeleteResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `disableWebhook()`

```php
disableWebhook($webhook): \OpenAPI\Client\Model\WebhookResponse
```

Disable webhook

Deactivate a webhook endpoint without deleting it. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.

try {
    $result = $apiInstance->disableWebhook($webhook);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->disableWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |

### Return type

[**\OpenAPI\Client\Model\WebhookResponse**](../Model/WebhookResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `enableWebhook()`

```php
enableWebhook($webhook): \OpenAPI\Client\Model\WebhookResponse
```

Enable webhook

Activate a disabled webhook endpoint. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.

try {
    $result = $apiInstance->enableWebhook($webhook);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->enableWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |

### Return type

[**\OpenAPI\Client\Model\WebhookResponse**](../Model/WebhookResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getWebhook()`

```php
getWebhook($webhook): \OpenAPI\Client\Model\WebhookResponse
```

Get webhook

Retrieve a webhook endpoint by UUID. Required scope: `webhooks.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.

try {
    $result = $apiInstance->getWebhook($webhook);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->getWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |

### Return type

[**\OpenAPI\Client\Model\WebhookResponse**](../Model/WebhookResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getWebhookDelivery()`

```php
getWebhookDelivery($webhook_delivery): \OpenAPI\Client\Model\WebhookDeliveryResponse
```

Get webhook delivery

Retrieve a webhook delivery attempt by UUID, including request and response detail. Required scope: `webhooks.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook_delivery = 'webhook_delivery_example'; // string | Webhook delivery UUID.

try {
    $result = $apiInstance->getWebhookDelivery($webhook_delivery);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->getWebhookDelivery: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook_delivery** | **string**| Webhook delivery UUID. | |

### Return type

[**\OpenAPI\Client\Model\WebhookDeliveryResponse**](../Model/WebhookDeliveryResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listWebhookDeliveries()`

```php
listWebhookDeliveries($webhook, $status, $event_type, $search, $http_status, $from, $to, $per_page): \OpenAPI\Client\Model\WebhookDeliveryListResponse
```

List webhook deliveries

List delivery attempts for a webhook with status, event, and date filters. Required scope: `webhooks.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.
$status = failed; // string | Filter by delivery status (`pending`, `delivered`, `failed`).
$event_type = email.delivered; // string | Filter by event type.
$search = 'search_example'; // string | Free-text search.
$http_status = 500; // int | Filter by returned HTTP status code.
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter deliveries on or after this ISO-8601 date.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter deliveries on or before this ISO-8601 date.
$per_page = 25; // int | Items per page (default 25).

try {
    $result = $apiInstance->listWebhookDeliveries($webhook, $status, $event_type, $search, $http_status, $from, $to, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->listWebhookDeliveries: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |
| **status** | **string**| Filter by delivery status (&#x60;pending&#x60;, &#x60;delivered&#x60;, &#x60;failed&#x60;). | [optional] |
| **event_type** | **string**| Filter by event type. | [optional] |
| **search** | **string**| Free-text search. | [optional] |
| **http_status** | **int**| Filter by returned HTTP status code. | [optional] |
| **from** | **\DateTime**| Filter deliveries on or after this ISO-8601 date. | [optional] |
| **to** | **\DateTime**| Filter deliveries on or before this ISO-8601 date. | [optional] |
| **per_page** | **int**| Items per page (default 25). | [optional] |

### Return type

[**\OpenAPI\Client\Model\WebhookDeliveryListResponse**](../Model/WebhookDeliveryListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listWebhooks()`

```php
listWebhooks($search, $status, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\WebhookListResponse
```

List webhooks

List registered webhook endpoints with optional search, status filter, and pagination. Required scope: `webhooks.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = production; // string | Free-text search across name and URL.
$status = active; // string | Filter by status (`active` or `inactive`).
$sort = created_at; // string | Sort field.
$direction = desc; // string | Sort direction.
$page = 1; // int | Page number (1-based).
$per_page = 25; // int | Items per page (default 25).

try {
    $result = $apiInstance->listWebhooks($search, $status, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->listWebhooks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Free-text search across name and URL. | [optional] |
| **status** | **string**| Filter by status (&#x60;active&#x60; or &#x60;inactive&#x60;). | [optional] |
| **sort** | **string**| Sort field. | [optional] |
| **direction** | **string**| Sort direction. | [optional] |
| **page** | **int**| Page number (1-based). | [optional] |
| **per_page** | **int**| Items per page (default 25). | [optional] |

### Return type

[**\OpenAPI\Client\Model\WebhookListResponse**](../Model/WebhookListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `replayWebhookDeliveries()`

```php
replayWebhookDeliveries($webhook, $replay_webhook_request): \OpenAPI\Client\Model\WebhookReplayResponse
```

Replay webhook deliveries

Re-queue failed deliveries by date range and event type, or replay specific delivery UUIDs. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.
$replay_webhook_request = new \OpenAPI\Client\Model\ReplayWebhookRequest(); // \OpenAPI\Client\Model\ReplayWebhookRequest

try {
    $result = $apiInstance->replayWebhookDeliveries($webhook, $replay_webhook_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->replayWebhookDeliveries: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |
| **replay_webhook_request** | [**\OpenAPI\Client\Model\ReplayWebhookRequest**](../Model/ReplayWebhookRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\WebhookReplayResponse**](../Model/WebhookReplayResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `replayWebhookDelivery()`

```php
replayWebhookDelivery($webhook_delivery): \OpenAPI\Client\Model\WebhookDeliveryResponse
```

Replay webhook delivery

Re-queue a single webhook delivery attempt. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook_delivery = 'webhook_delivery_example'; // string | Webhook delivery UUID.

try {
    $result = $apiInstance->replayWebhookDelivery($webhook_delivery);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->replayWebhookDelivery: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook_delivery** | **string**| Webhook delivery UUID. | |

### Return type

[**\OpenAPI\Client\Model\WebhookDeliveryResponse**](../Model/WebhookDeliveryResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `rotateWebhookSecret()`

```php
rotateWebhookSecret($webhook): \OpenAPI\Client\Model\WebhookSecretResponse
```

Rotate webhook secret

Generate a new HMAC signing secret. The new secret is returned only once. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.

try {
    $result = $apiInstance->rotateWebhookSecret($webhook);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->rotateWebhookSecret: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |

### Return type

[**\OpenAPI\Client\Model\WebhookSecretResponse**](../Model/WebhookSecretResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `testWebhook()`

```php
testWebhook($webhook, $test_webhook_request): \OpenAPI\Client\Model\WebhookDeliveryResponse
```

Test webhook

Queue a test event delivery to verify endpoint connectivity and signature handling. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.
$test_webhook_request = new \OpenAPI\Client\Model\TestWebhookRequest(); // \OpenAPI\Client\Model\TestWebhookRequest

try {
    $result = $apiInstance->testWebhook($webhook, $test_webhook_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->testWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |
| **test_webhook_request** | [**\OpenAPI\Client\Model\TestWebhookRequest**](../Model/TestWebhookRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\WebhookDeliveryResponse**](../Model/WebhookDeliveryResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateWebhook()`

```php
updateWebhook($webhook, $update_webhook_request): \OpenAPI\Client\Model\WebhookResponse
```

Update webhook

Update a webhook endpoint. Required scope: `webhooks.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook = 'webhook_example'; // string | Webhook UUID.
$update_webhook_request = new \OpenAPI\Client\Model\UpdateWebhookRequest(); // \OpenAPI\Client\Model\UpdateWebhookRequest

try {
    $result = $apiInstance->updateWebhook($webhook, $update_webhook_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->updateWebhook: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook** | **string**| Webhook UUID. | |
| **update_webhook_request** | [**\OpenAPI\Client\Model\UpdateWebhookRequest**](../Model/UpdateWebhookRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\WebhookResponse**](../Model/WebhookResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
