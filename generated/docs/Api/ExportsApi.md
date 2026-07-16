# OpenAPI\Client\ExportsApi

Queue, monitor, and download filtered contact exports.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**downloadContactExport()**](ExportsApi.md#downloadContactExport) | **GET** /contacts/exports/{contactExport}/download | Download contact export |
| [**exportContacts()**](ExportsApi.md#exportContacts) | **POST** /contacts/export | Export contacts |
| [**getContactExport()**](ExportsApi.md#getContactExport) | **GET** /contacts/exports/{contactExport} | Get contact export |


## `downloadContactExport()`

```php
downloadContactExport($contact_export): string
```

Download contact export

Download a completed CSV contact export. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ExportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact_export = 'contact_export_example'; // string | Contact export UUID.

try {
    $result = $apiInstance->downloadContactExport($contact_export);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportsApi->downloadContactExport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact_export** | **string**| Contact export UUID. | |

### Return type

**string**

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `exportContacts()`

```php
exportContacts($export_contacts_request): \OpenAPI\Client\Model\ExportJobResponse
```

Export contacts

Queue an asynchronous CSV contact export using optional filters or contact UUIDs. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ExportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$export_contacts_request = new \OpenAPI\Client\Model\ExportContactsRequest(); // \OpenAPI\Client\Model\ExportContactsRequest

try {
    $result = $apiInstance->exportContacts($export_contacts_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportsApi->exportContacts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **export_contacts_request** | [**\OpenAPI\Client\Model\ExportContactsRequest**](../Model/ExportContactsRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\ExportJobResponse**](../Model/ExportJobResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getContactExport()`

```php
getContactExport($contact_export): \OpenAPI\Client\Model\ExportJobResponse
```

Get contact export

Retrieve export status and download availability. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ExportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact_export = 'contact_export_example'; // string | Contact export UUID.

try {
    $result = $apiInstance->getContactExport($contact_export);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExportsApi->getContactExport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact_export** | **string**| Contact export UUID. | |

### Return type

[**\OpenAPI\Client\Model\ExportJobResponse**](../Model/ExportJobResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
