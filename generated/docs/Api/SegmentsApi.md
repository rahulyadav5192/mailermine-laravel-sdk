# OpenAPI\Client\SegmentsApi

Manage dynamic, rule-based contact segments.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**countSegment()**](SegmentsApi.md#countSegment) | **GET** /segments/{segment}/count | Refresh segment count |
| [**createSegment()**](SegmentsApi.md#createSegment) | **POST** /segments | Create segment |
| [**deleteSegment()**](SegmentsApi.md#deleteSegment) | **DELETE** /segments/{segment} | Delete segment |
| [**getSegment()**](SegmentsApi.md#getSegment) | **GET** /segments/{segment} | Get segment |
| [**listSegments()**](SegmentsApi.md#listSegments) | **GET** /segments | List segments |
| [**previewSegment()**](SegmentsApi.md#previewSegment) | **POST** /segments/{segment}/preview | Preview segment |
| [**previewSegmentRules()**](SegmentsApi.md#previewSegmentRules) | **POST** /segments/preview | Preview segment rules |
| [**updateSegment()**](SegmentsApi.md#updateSegment) | **PATCH** /segments/{segment} | Update segment |


## `countSegment()`

```php
countSegment($segment): \OpenAPI\Client\Model\SegmentCountResponse
```

Refresh segment count

Recalculate and persist the saved segment contact count. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$segment = 'segment_example'; // string | Segment UUID.

try {
    $result = $apiInstance->countSegment($segment);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->countSegment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **segment** | **string**| Segment UUID. | |

### Return type

[**\OpenAPI\Client\Model\SegmentCountResponse**](../Model/SegmentCountResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createSegment()`

```php
createSegment($create_segment_request): \OpenAPI\Client\Model\SegmentResponse
```

Create segment

Create a dynamic contact segment from validated rules. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_segment_request = new \OpenAPI\Client\Model\CreateSegmentRequest(); // \OpenAPI\Client\Model\CreateSegmentRequest

try {
    $result = $apiInstance->createSegment($create_segment_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->createSegment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_segment_request** | [**\OpenAPI\Client\Model\CreateSegmentRequest**](../Model/CreateSegmentRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\SegmentResponse**](../Model/SegmentResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteSegment()`

```php
deleteSegment($segment): \OpenAPI\Client\Model\DeleteResponse
```

Delete segment

Delete a dynamic segment. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$segment = 'segment_example'; // string | Segment UUID.

try {
    $result = $apiInstance->deleteSegment($segment);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->deleteSegment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **segment** | **string**| Segment UUID. | |

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

## `getSegment()`

```php
getSegment($segment): \OpenAPI\Client\Model\SegmentResponse
```

Get segment

Retrieve a dynamic segment. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$segment = 'segment_example'; // string | Segment UUID.

try {
    $result = $apiInstance->getSegment($segment);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->getSegment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **segment** | **string**| Segment UUID. | |

### Return type

[**\OpenAPI\Client\Model\SegmentResponse**](../Model/SegmentResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listSegments()`

```php
listSegments($search, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\SegmentCollection
```

List segments

List dynamic contact segments. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = Engaged; // string | Search segment names.
$sort = created_at; // string | Sort field.
$direction = desc; // string | Sort direction.
$page = 1; // int | Page number.
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listSegments($search, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->listSegments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search segment names. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\SegmentCollection**](../Model/SegmentCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `previewSegment()`

```php
previewSegment($segment): \OpenAPI\Client\Model\SegmentPreviewResponse
```

Preview segment

Return a count and up to ten contacts matching a saved segment. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$segment = 'segment_example'; // string | Segment UUID.

try {
    $result = $apiInstance->previewSegment($segment);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->previewSegment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **segment** | **string**| Segment UUID. | |

### Return type

[**\OpenAPI\Client\Model\SegmentPreviewResponse**](../Model/SegmentPreviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `previewSegmentRules()`

```php
previewSegmentRules($preview_segment_request): \OpenAPI\Client\Model\SegmentPreviewResponse
```

Preview segment rules

Validate unsaved rules and return a count plus up to ten matching contacts. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$preview_segment_request = new \OpenAPI\Client\Model\PreviewSegmentRequest(); // \OpenAPI\Client\Model\PreviewSegmentRequest

try {
    $result = $apiInstance->previewSegmentRules($preview_segment_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->previewSegmentRules: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **preview_segment_request** | [**\OpenAPI\Client\Model\PreviewSegmentRequest**](../Model/PreviewSegmentRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\SegmentPreviewResponse**](../Model/SegmentPreviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateSegment()`

```php
updateSegment($segment, $update_segment_request): \OpenAPI\Client\Model\SegmentResponse
```

Update segment

Update segment metadata or rules. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\SegmentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$segment = 'segment_example'; // string | Segment UUID.
$update_segment_request = new \OpenAPI\Client\Model\UpdateSegmentRequest(); // \OpenAPI\Client\Model\UpdateSegmentRequest

try {
    $result = $apiInstance->updateSegment($segment, $update_segment_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SegmentsApi->updateSegment: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **segment** | **string**| Segment UUID. | |
| **update_segment_request** | [**\OpenAPI\Client\Model\UpdateSegmentRequest**](../Model/UpdateSegmentRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\SegmentResponse**](../Model/SegmentResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
