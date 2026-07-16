# OpenAPI\Client\SuppressionsApi

Manage suppressed recipient addresses that are skipped when sending.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createSuppression()**](SuppressionsApi.md#createSuppression) | **POST** /suppressions | Create suppression |
| [**deleteSuppression()**](SuppressionsApi.md#deleteSuppression) | **DELETE** /suppressions/{suppression} | Delete suppression |
| [**listSuppressions()**](SuppressionsApi.md#listSuppressions) | **GET** /suppressions | List suppressions |
| [**restoreSuppression()**](SuppressionsApi.md#restoreSuppression) | **POST** /suppressions/{suppression}/restore | Restore suppression |


## `createSuppression()`

```php
createSuppression($create_suppression_request): \OpenAPI\Client\Model\SuppressionResponse
```

Create suppression

Add a recipient address to the project suppression list. Required scope: `suppressions.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SuppressionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_suppression_request = new \OpenAPI\Client\Model\CreateSuppressionRequest(); // \OpenAPI\Client\Model\CreateSuppressionRequest

try {
    $result = $apiInstance->createSuppression($create_suppression_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuppressionsApi->createSuppression: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_suppression_request** | [**\OpenAPI\Client\Model\CreateSuppressionRequest**](../Model/CreateSuppressionRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\SuppressionResponse**](../Model/SuppressionResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteSuppression()`

```php
deleteSuppression($suppression): \OpenAPI\Client\Model\DeleteResponse
```

Delete suppression

Permanently remove a suppression, allowing the address to receive mail again. Required scope: `suppressions.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SuppressionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$suppression = 'suppression_example'; // string | Suppression UUID.

try {
    $result = $apiInstance->deleteSuppression($suppression);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuppressionsApi->deleteSuppression: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **suppression** | **string**| Suppression UUID. | |

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

## `listSuppressions()`

```php
listSuppressions($search, $reason, $per_page): \OpenAPI\Client\Model\SuppressionListResponse
```

List suppressions

List suppressed recipient addresses with optional search and reason filter. Required scope: `suppressions.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SuppressionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = example.com; // string | Free-text search across email addresses.
$reason = bounce; // string | Filter by suppression reason (`bounce`, `complaint`, `manual`, `unsubscribe`).
$per_page = 25; // int | Items per page (default 25).

try {
    $result = $apiInstance->listSuppressions($search, $reason, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuppressionsApi->listSuppressions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Free-text search across email addresses. | [optional] |
| **reason** | **string**| Filter by suppression reason (&#x60;bounce&#x60;, &#x60;complaint&#x60;, &#x60;manual&#x60;, &#x60;unsubscribe&#x60;). | [optional] |
| **per_page** | **int**| Items per page (default 25). | [optional] |

### Return type

[**\OpenAPI\Client\Model\SuppressionListResponse**](../Model/SuppressionListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `restoreSuppression()`

```php
restoreSuppression($suppression): \OpenAPI\Client\Model\SuppressionResponse
```

Restore suppression

Restore a soft-deleted suppression by UUID. Required scope: `suppressions.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SuppressionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$suppression = 'suppression_example'; // string | Suppression UUID.

try {
    $result = $apiInstance->restoreSuppression($suppression);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SuppressionsApi->restoreSuppression: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **suppression** | **string**| Suppression UUID. | |

### Return type

[**\OpenAPI\Client\Model\SuppressionResponse**](../Model/SuppressionResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
