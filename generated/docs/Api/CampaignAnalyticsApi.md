# OpenAPI\Client\CampaignAnalyticsApi



All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**campaignAnalytics()**](CampaignAnalyticsApi.md#campaignAnalytics) | **GET** /campaigns/{campaign}/analytics | Get campaign analytics |
| [**campaignLinks()**](CampaignAnalyticsApi.md#campaignLinks) | **GET** /campaigns/{campaign}/links | Get campaign links |


## `campaignAnalytics()`

```php
campaignAnalytics($campaign): \OpenAPI\Client\Model\CampaignAnalyticsResponse
```

Get campaign analytics

Return delivery, engagement, failure, unsubscribe, and top-link statistics. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignAnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->campaignAnalytics($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignAnalyticsApi->campaignAnalytics: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignAnalyticsResponse**](../Model/CampaignAnalyticsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `campaignLinks()`

```php
campaignLinks($campaign): \OpenAPI\Client\Model\CampaignLinksResponse
```

Get campaign links

Return tracked-link click and CTR statistics. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignAnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->campaignLinks($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignAnalyticsApi->campaignLinks: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignLinksResponse**](../Model/CampaignLinksResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
