# OpenAPI\Client\CampaignsApi

Build and manage project-scoped marketing campaigns.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createCampaign()**](CampaignsApi.md#createCampaign) | **POST** /campaigns | Create campaign |
| [**deleteCampaign()**](CampaignsApi.md#deleteCampaign) | **DELETE** /campaigns/{campaign} | Delete campaign |
| [**getCampaign()**](CampaignsApi.md#getCampaign) | **GET** /campaigns/{campaign} | Get campaign |
| [**listCampaigns()**](CampaignsApi.md#listCampaigns) | **GET** /campaigns | List campaigns |
| [**previewCampaign()**](CampaignsApi.md#previewCampaign) | **GET** /campaigns/{campaign}/preview | Preview campaign |
| [**previewCampaignRecipients()**](CampaignsApi.md#previewCampaignRecipients) | **GET** /campaigns/{campaign}/recipient-preview | Preview campaign recipients |
| [**updateCampaign()**](CampaignsApi.md#updateCampaign) | **PATCH** /campaigns/{campaign} | Update campaign |
| [**validateCampaign()**](CampaignsApi.md#validateCampaign) | **GET** /campaigns/{campaign}/validate | Validate campaign |


## `createCampaign()`

```php
createCampaign($create_campaign_request): \OpenAPI\Client\Model\CampaignResponse
```

Create campaign

Create a draft campaign in the API key project. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_campaign_request = new \OpenAPI\Client\Model\CreateCampaignRequest(); // \OpenAPI\Client\Model\CreateCampaignRequest

try {
    $result = $apiInstance->createCampaign($create_campaign_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->createCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_campaign_request** | [**\OpenAPI\Client\Model\CreateCampaignRequest**](../Model/CreateCampaignRequest.md)|  | |

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

## `deleteCampaign()`

```php
deleteCampaign($campaign): \OpenAPI\Client\Model\DeleteResponse
```

Delete campaign

Soft-delete a campaign. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->deleteCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->deleteCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

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

## `getCampaign()`

```php
getCampaign($campaign): \OpenAPI\Client\Model\CampaignResponse
```

Get campaign

Retrieve campaign configuration, relationships, and send counters. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->getCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->getCampaign: ', $e->getMessage(), PHP_EOL;
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

## `listCampaigns()`

```php
listCampaigns($search, $status, $page, $per_page): \OpenAPI\Client\Model\CampaignCollection
```

List campaigns

List campaigns for the API key project. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = August; // string | Search campaign name or subject.
$status = scheduled; // string | Filter by lifecycle status.
$page = 1; // int | Page number.
$per_page = 15; // int | Items per page (maximum 100).

try {
    $result = $apiInstance->listCampaigns($search, $status, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->listCampaigns: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search campaign name or subject. | [optional] |
| **status** | **string**| Filter by lifecycle status. | [optional] |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page (maximum 100). | [optional] [default to 15] |

### Return type

[**\OpenAPI\Client\Model\CampaignCollection**](../Model/CampaignCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `previewCampaign()`

```php
previewCampaign($campaign): \OpenAPI\Client\Model\CampaignPreviewResponse
```

Preview campaign

Render the current campaign subject and bodies without sending. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->previewCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->previewCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignPreviewResponse**](../Model/CampaignPreviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `previewCampaignRecipients()`

```php
previewCampaignRecipients($campaign): \OpenAPI\Client\Model\CampaignRecipientPreviewResponse
```

Preview campaign recipients

Estimate the selected audience and return representative contacts. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->previewCampaignRecipients($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->previewCampaignRecipients: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignRecipientPreviewResponse**](../Model/CampaignRecipientPreviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateCampaign()`

```php
updateCampaign($campaign, $update_campaign_request): \OpenAPI\Client\Model\CampaignResponse
```

Update campaign

Update an editable campaign and its template, audience, sender, or delivery settings. Required scope: `campaigns.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.
$update_campaign_request = new \OpenAPI\Client\Model\UpdateCampaignRequest(); // \OpenAPI\Client\Model\UpdateCampaignRequest

try {
    $result = $apiInstance->updateCampaign($campaign, $update_campaign_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->updateCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |
| **update_campaign_request** | [**\OpenAPI\Client\Model\UpdateCampaignRequest**](../Model/UpdateCampaignRequest.md)|  | [optional] |

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

## `validateCampaign()`

```php
validateCampaign($campaign): \OpenAPI\Client\Model\CampaignValidationResponse
```

Validate campaign

Check sender, template, audience, and delivery readiness. Required scope: `campaigns.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\CampaignsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$campaign = 'campaign_example'; // string | Campaign UUID.

try {
    $result = $apiInstance->validateCampaign($campaign);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CampaignsApi->validateCampaign: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **campaign** | **string**| Campaign UUID. | |

### Return type

[**\OpenAPI\Client\Model\CampaignValidationResponse**](../Model/CampaignValidationResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
