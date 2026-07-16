# OpenAPI\Client\EventsApi

Query recipient delivery and engagement events across the project.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getEvent()**](EventsApi.md#getEvent) | **GET** /events/{emailEvent} | Get event |
| [**listEvents()**](EventsApi.md#listEvents) | **GET** /events | List events |


## `getEvent()`

```php
getEvent($email_event): \OpenAPI\Client\Model\EventResponse
```

Get event

Retrieve a single email event by UUID. Required scope: `events.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$email_event = 'email_event_example'; // string | Event UUID.

try {
    $result = $apiInstance->getEvent($email_event);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EventsApi->getEvent: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **email_event** | **string**| Event UUID. | |

### Return type

[**\OpenAPI\Client\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listEvents()`

```php
listEvents($event_type, $source, $campaign, $message, $search, $from, $to, $per_page): \OpenAPI\Client\Model\EventListResponse
```

List events

List recipient delivery and engagement events with filters for type, source, campaign, message, and date range. Required scope: `events.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$event_type = delivered; // string | Filter by event type (for example `delivered`, `opened`, `clicked`).
$source = transactional; // string | Filter by event source.
$campaign = 'campaign_example'; // string | Filter by campaign UUID.
$message = 'message_example'; // string | Filter by message UUID.
$search = 'search_example'; // string | Free-text search across recipient and payload.
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter events on or after this ISO-8601 date.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter events on or before this ISO-8601 date.
$per_page = 25; // int | Items per page (default 25).

try {
    $result = $apiInstance->listEvents($event_type, $source, $campaign, $message, $search, $from, $to, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EventsApi->listEvents: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **event_type** | **string**| Filter by event type (for example &#x60;delivered&#x60;, &#x60;opened&#x60;, &#x60;clicked&#x60;). | [optional] |
| **source** | **string**| Filter by event source. | [optional] |
| **campaign** | **string**| Filter by campaign UUID. | [optional] |
| **message** | **string**| Filter by message UUID. | [optional] |
| **search** | **string**| Free-text search across recipient and payload. | [optional] |
| **from** | **\DateTime**| Filter events on or after this ISO-8601 date. | [optional] |
| **to** | **\DateTime**| Filter events on or before this ISO-8601 date. | [optional] |
| **per_page** | **int**| Items per page (default 25). | [optional] |

### Return type

[**\OpenAPI\Client\Model\EventListResponse**](../Model/EventListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
