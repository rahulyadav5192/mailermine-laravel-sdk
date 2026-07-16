# OpenAPI\Client\MessagesApi

List messages, retrieve delivery details, and inspect lifecycle events.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getMessage()**](MessagesApi.md#getMessage) | **GET** /delivery-logs/{message} | Get message |
| [**listMessages()**](MessagesApi.md#listMessages) | **GET** /delivery-logs | List messages |
| [**messageEvents()**](MessagesApi.md#messageEvents) | **GET** /messages/{message}/events | Message events |


## `getMessage()`

```php
getMessage($message): \OpenAPI\Client\Model\MessageDetailResponse
```

Get message

Retrieve a single message by UUID with delivery timeline events.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$message = 'message_example'; // string | The message UUID

try {
    $result = $apiInstance->getMessage($message);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->getMessage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **message** | **string**| The message UUID | |

### Return type

[**\OpenAPI\Client\Model\MessageDetailResponse**](../Model/MessageDetailResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listMessages()`

```php
listMessages($search, $status, $provider, $from, $to, $page, $per_page): \OpenAPI\Client\Model\MessageListResponse
```

List messages

List sent and queued messages for your project with optional filters and pagination.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = invoice; // string | Free-text search across subject and recipient.
$status = sent; // string | Filter by message status.
$provider = aws; // string | Filter by delivery provider.
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter messages sent on or after this ISO-8601 date.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter messages sent on or before this ISO-8601 date.
$page = 1; // int | Page number (1-based).
$per_page = 25; // int | Items per page (default 25).

try {
    $result = $apiInstance->listMessages($search, $status, $provider, $from, $to, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->listMessages: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Free-text search across subject and recipient. | [optional] |
| **status** | **string**| Filter by message status. | [optional] |
| **provider** | **string**| Filter by delivery provider. | [optional] |
| **from** | **\DateTime**| Filter messages sent on or after this ISO-8601 date. | [optional] |
| **to** | **\DateTime**| Filter messages sent on or before this ISO-8601 date. | [optional] |
| **page** | **int**| Page number (1-based). | [optional] |
| **per_page** | **int**| Items per page (default 25). | [optional] |

### Return type

[**\OpenAPI\Client\Model\MessageListResponse**](../Model/MessageListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `messageEvents()`

```php
messageEvents($message): \OpenAPI\Client\Model\MessageEventsResponse
```

Message events

Retrieve lifecycle events for a single message.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$message = 'message_example'; // string | The message UUID

try {
    $result = $apiInstance->messageEvents($message);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->messageEvents: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **message** | **string**| The message UUID | |

### Return type

[**\OpenAPI\Client\Model\MessageEventsResponse**](../Model/MessageEventsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
