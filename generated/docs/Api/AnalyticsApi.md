# OpenAPI\Client\AnalyticsApi

Aggregate delivery, engagement, provider, domain, and project reporting.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**analyticsCampaigns()**](AnalyticsApi.md#analyticsCampaigns) | **GET** /analytics/campaigns | Campaign analytics breakdown |
| [**analyticsDomains()**](AnalyticsApi.md#analyticsDomains) | **GET** /analytics/domains | Domain analytics |
| [**analyticsEngagement()**](AnalyticsApi.md#analyticsEngagement) | **GET** /analytics/engagement | Engagement analytics |
| [**analyticsMessages()**](AnalyticsApi.md#analyticsMessages) | **GET** /analytics/messages | Message analytics |
| [**analyticsOverview()**](AnalyticsApi.md#analyticsOverview) | **GET** /analytics/overview | Analytics overview |
| [**analyticsProjects()**](AnalyticsApi.md#analyticsProjects) | **GET** /analytics/projects | Project analytics |
| [**analyticsProviders()**](AnalyticsApi.md#analyticsProviders) | **GET** /analytics/providers | Provider analytics |


## `analyticsCampaigns()`

```php
analyticsCampaigns($from, $to): \OpenAPI\Client\Model\AnalyticsCampaignsResponse
```

Campaign analytics breakdown

Return the top campaigns by volume with open and click rates. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsCampaigns($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsCampaigns: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsCampaignsResponse**](../Model/AnalyticsCampaignsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `analyticsDomains()`

```php
analyticsDomains($from, $to): \OpenAPI\Client\Model\AnalyticsDomainsResponse
```

Domain analytics

Return message volume grouped by sending domain (top 50). Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsDomains($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsDomains: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsDomainsResponse**](../Model/AnalyticsDomainsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `analyticsEngagement()`

```php
analyticsEngagement($from, $to): \OpenAPI\Client\Model\AnalyticsEngagementResponse
```

Engagement analytics

Return open, click, CTR, and CTOR engagement rates. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsEngagement($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsEngagement: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsEngagementResponse**](../Model/AnalyticsEngagementResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `analyticsMessages()`

```php
analyticsMessages($from, $to): \OpenAPI\Client\Model\AnalyticsMessagesResponse
```

Message analytics

Return message totals, status breakdown, and daily metrics. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsMessages($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsMessages: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsMessagesResponse**](../Model/AnalyticsMessagesResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `analyticsOverview()`

```php
analyticsOverview($from, $to): \OpenAPI\Client\Model\AnalyticsOverviewResponse
```

Analytics overview

Return aggregate performance metrics, daily series, top campaigns, and recent activity. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsOverview($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsOverview: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsOverviewResponse**](../Model/AnalyticsOverviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `analyticsProjects()`

```php
analyticsProjects($from, $to): \OpenAPI\Client\Model\AnalyticsProjectsResponse
```

Project analytics

Return performance metrics for the authenticated project. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsProjects($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsProjects: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsProjectsResponse**](../Model/AnalyticsProjectsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `analyticsProviders()`

```php
analyticsProviders($from, $to): \OpenAPI\Client\Model\AnalyticsProvidersResponse
```

Provider analytics

Return message volume grouped by delivery provider. Required scope: `analytics.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AnalyticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range start (ISO-8601). Defaults to 30 days ago.
$to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Range end (ISO-8601). Defaults to now.

try {
    $result = $apiInstance->analyticsProviders($from, $to);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AnalyticsApi->analyticsProviders: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **from** | **\DateTime**| Range start (ISO-8601). Defaults to 30 days ago. | [optional] |
| **to** | **\DateTime**| Range end (ISO-8601). Defaults to now. | [optional] |

### Return type

[**\OpenAPI\Client\Model\AnalyticsProvidersResponse**](../Model/AnalyticsProvidersResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
