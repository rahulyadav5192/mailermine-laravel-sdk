# OpenAPI\Client\ImportsApi

Upload, configure, queue, and monitor contact imports.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**configureContactImport()**](ImportsApi.md#configureContactImport) | **POST** /contacts/imports/{contactImport}/config | Configure contact import |
| [**downloadContactImportFailures()**](ImportsApi.md#downloadContactImportFailures) | **GET** /contacts/imports/{contactImport}/failures | Download import failures |
| [**getContactImport()**](ImportsApi.md#getContactImport) | **GET** /contacts/imports/{contactImport} | Get contact import |
| [**importContacts()**](ImportsApi.md#importContacts) | **POST** /contacts/import | Upload contact import |
| [**listContactImports()**](ImportsApi.md#listContactImports) | **GET** /contacts/imports | List contact imports |
| [**startContactImport()**](ImportsApi.md#startContactImport) | **POST** /contacts/imports/{contactImport}/start | Start contact import |


## `configureContactImport()`

```php
configureContactImport($contact_import, $configure_contact_import_request): \OpenAPI\Client\Model\ImportJobResponse
```

Configure contact import

Save column mappings and duplicate-handling behavior before starting an import. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact_import = 'contact_import_example'; // string | Contact import UUID.
$configure_contact_import_request = new \OpenAPI\Client\Model\ConfigureContactImportRequest(); // \OpenAPI\Client\Model\ConfigureContactImportRequest

try {
    $result = $apiInstance->configureContactImport($contact_import, $configure_contact_import_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImportsApi->configureContactImport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact_import** | **string**| Contact import UUID. | |
| **configure_contact_import_request** | [**\OpenAPI\Client\Model\ConfigureContactImportRequest**](../Model/ConfigureContactImportRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\ImportJobResponse**](../Model/ImportJobResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `downloadContactImportFailures()`

```php
downloadContactImportFailures($contact_import): string
```

Download import failures

Download the CSV failure report generated for an import. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact_import = 'contact_import_example'; // string | Contact import UUID.

try {
    $result = $apiInstance->downloadContactImportFailures($contact_import);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImportsApi->downloadContactImportFailures: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact_import** | **string**| Contact import UUID. | |

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

## `getContactImport()`

```php
getContactImport($contact_import): \OpenAPI\Client\Model\ImportJobDetailResponse
```

Get contact import

Retrieve import status, counters, metadata, and live progress. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact_import = 'contact_import_example'; // string | Contact import UUID.

try {
    $result = $apiInstance->getContactImport($contact_import);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImportsApi->getContactImport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact_import** | **string**| Contact import UUID. | |

### Return type

[**\OpenAPI\Client\Model\ImportJobDetailResponse**](../Model/ImportJobDetailResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `importContacts()`

```php
importContacts($import_contacts_request): \OpenAPI\Client\Model\ImportJobResponse
```

Upload contact import

Upload a contact import file (maximum 50 MiB) for parsing and configuration. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$import_contacts_request = new \OpenAPI\Client\Model\ImportContactsRequest(); // \OpenAPI\Client\Model\ImportContactsRequest

try {
    $result = $apiInstance->importContacts($import_contacts_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImportsApi->importContacts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **import_contacts_request** | [**\OpenAPI\Client\Model\ImportContactsRequest**](../Model/ImportContactsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\ImportJobResponse**](../Model/ImportJobResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listContactImports()`

```php
listContactImports(): \OpenAPI\Client\Model\ImportJobCollection
```

List contact imports

Return the 50 most recent contact import jobs. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listContactImports();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImportsApi->listContactImports: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\ImportJobCollection**](../Model/ImportJobCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `startContactImport()`

```php
startContactImport($contact_import): \OpenAPI\Client\Model\ImportJobResponse
```

Start contact import

Queue a configured contact import for processing. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImportsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact_import = 'contact_import_example'; // string | Contact import UUID.

try {
    $result = $apiInstance->startContactImport($contact_import);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImportsApi->startContactImport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact_import** | **string**| Contact import UUID. | |

### Return type

[**\OpenAPI\Client\Model\ImportJobResponse**](../Model/ImportJobResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
