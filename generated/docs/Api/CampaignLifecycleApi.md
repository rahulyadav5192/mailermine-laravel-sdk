# OpenAPI\Client\CampaignLifecycleApi



All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**archiveCampaign()**](CampaignLifecycleApi.md#archiveCampaign) | **POST** /campaigns/{campaign}/archive | Archive campaign |
| [**cancelCampaign()**](CampaignLifecycleApi.md#cancelCampaign) | **POST** /campaigns/{campaign}/cancel | Cancel campaign |
| [**duplicateCampaign()**](CampaignLifecycleApi.md#duplicateCampaign) | **POST** /campaigns/{campaign}/duplicate | Duplicate campaign |
| [**getCampaignProgress()**](CampaignLifecycleApi.md#getCampaignProgress) | **GET** /campaigns/{campaign}/progress | Get campaign progress |
| [**pauseCampaign()**](CampaignLifecycleApi.md#pauseCampaign) | **POST** /campaigns/{campaign}/pause | Pause campaign |
| [**readyCampaign()**](CampaignLifecycleApi.md#readyCampaign) | **POST** /campaigns/{campaign}/mark-ready | Mark campaign ready |
| [**restoreCampaign()**](CampaignLifecycleApi.md#restoreCampaign) | **POST** /campaigns/{campaignUuid}/restore | Restore campaign |
| [**resumeCampaign()**](CampaignLifecycleApi.md#resumeCampaign) | **POST** /campaigns/{campaign}/resume | Resume campaign |
| [**scheduleCampaign()**](CampaignLifecycleApi.md#scheduleCampaign) | **POST** /campaigns/{campaign}/schedule | Schedule campaign |
| [**sendCampaign()**](CampaignLifecycleApi.md#sendCampaign) | **POST** /campaigns/{campaign}/send | Send campaign |


## `archiveCampaign()`

```php
archiveCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Archive campaign

Move a campaign to the archived state. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->archiveCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->archiveCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `cancelCampaign()`

```php
cancelCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Cancel campaign

Cancel a draft, scheduled, ready, paused, or sending campaign. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->cancelCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->cancelCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `duplicateCampaign()`

```php
duplicateCampaign($campaign, $duplicate_campaign_request): \OpenAPI\Client\Model\CampaignResponse
```

Duplicate campaign

Create an editable draft copy. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.
$duplicate_campaign_request = new \OpenAPI\Client\Model\DuplicateCampaignRequest(); // \OpenAPI\Client\Model\DuplicateCampaignRequest

try {
    $result = $apiInstance->duplicateCampaign($campaign, $duplicate_campaign_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->duplicateCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |
| **duplicate_campaign_request** | [**\OpenAPI\Client\Model\DuplicateCampaignRequest**](../Model/DuplicateCampaignRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getCampaignProgress()`

```php
getCampaignProgress($campaign): \OpenAPI\Client\Model\CampaignStatisticsResponse
```

Get campaign progress

Poll asynchronous recipient processing counters. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->getCampaignProgress($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->getCampaignProgress: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignStatisticsResponse**](../Model/CampaignStatisticsResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `pauseCampaign()`

```php
pauseCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Pause campaign

Pause a scheduled, ready, or sending campaign. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->pauseCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->pauseCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `readyCampaign()`

```php
readyCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Mark campaign ready

Validate a configured campaign and mark it ready to send. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->readyCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->readyCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `restoreCampaign()`

```php
restoreCampaign($campaign_uuid): \OpenAPI\Client\Model\CampaignResponse
```

Restore campaign

Restore one soft-deleted campaign. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign_uuid = 'campaign_uuid_example'; // string | Deleted campaign UUID.

try {
    $result = $apiInstance->restoreCampaign($campaign_uuid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->restoreCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign_uuid** | **string**| Deleted campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `resumeCampaign()`

```php
resumeCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Resume campaign

Resume a paused campaign, including queued delivery when already started. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->resumeCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->resumeCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `scheduleCampaign()`

```php
scheduleCampaign($campaign, $schedule_campaign_request): \OpenAPI\Client\Model\CampaignResponse
```

Schedule campaign

Schedule future delivery or mark the campaign ready for immediate delivery. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.
$schedule_campaign_request = new \OpenAPI\Client\Model\ScheduleCampaignRequest(); // \OpenAPI\Client\Model\ScheduleCampaignRequest

try {
    $result = $apiInstance->scheduleCampaign($campaign, $schedule_campaign_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->scheduleCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |
| **schedule_campaign_request** | [**\OpenAPI\Client\Model\ScheduleCampaignRequest**](../Model/ScheduleCampaignRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sendCampaign()`

```php
sendCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Send campaign

Snapshot recipients and queue campaign delivery. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignLifecycleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->sendCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignLifecycleApi->sendCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignResponse**](../Model/CampaignResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
