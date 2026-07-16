# OpenAPI\Client\CampaignEventsApi



All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**campaignActivities()**](CampaignEventsApi.md#campaignActivities) | **GET** /campaigns/{campaign}/activities | List campaign activities |
| [**campaignEvents()**](CampaignEventsApi.md#campaignEvents) | **GET** /campaigns/{campaign}/events | List campaign events |
| [**campaignRecipients()**](CampaignEventsApi.md#campaignRecipients) | **GET** /campaigns/{campaign}/recipients | List campaign recipients |
| [**campaignTimeline()**](CampaignEventsApi.md#campaignTimeline) | **GET** /campaigns/{campaign}/timeline | Get campaign timeline |


## `campaignActivities()`

```php
campaignActivities($campaign): \OpenAPI\Client\Model\CampaignActivityCollection
```

List campaign activities

List campaign-level lifecycle activities. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->campaignActivities($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignEventsApi->campaignActivities: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignActivityCollection**](../Model/CampaignActivityCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `campaignEvents()`

```php
campaignEvents($campaign): \OpenAPI\Client\Model\CampaignEventsResponse
```

List campaign events

Return paginated recipient delivery and engagement events. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->campaignEvents($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignEventsApi->campaignEvents: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignEventsResponse**](../Model/CampaignEventsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `campaignRecipients()`

```php
campaignRecipients($campaign, $search, $status, $page): \OpenAPI\Client\Model\CampaignRecipientCollection
```

List campaign recipients

List recipient snapshots with delivery and message status. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.
$search = ada@example.com; // string | Search recipient email or name.
$status = delivered; // string | Filter by recipient status.
$page = 1; // int | Page number.

try {
    $result = $apiInstance->campaignRecipients($campaign, $search, $status, $page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignEventsApi->campaignRecipients: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |
| **search** | **string**| Search recipient email or name. | [optional] |
| **status** | **string**| Filter by recipient status. | [optional] |
| **page** | **int**| Page number. | [optional] [default to 1] |

### Return type

[**\OpenAPI\Client\Model\CampaignRecipientCollection**](../Model/CampaignRecipientCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `campaignTimeline()`

```php
campaignTimeline($campaign): \OpenAPI\Client\Model\CampaignTimelineResponse
```

Get campaign timeline

Return recent delivery and recipient-failure events. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignEventsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->campaignTimeline($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignEventsApi->campaignTimeline: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignTimelineResponse**](../Model/CampaignTimelineResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
