# OpenAPI\Client\MarketingApi

Manage reusable marketing data definitions such as contact custom fields.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createCustomField()**](MarketingApi.md#createCustomField) | **POST** /custom-fields | Create custom field |
| [**deleteCustomField()**](MarketingApi.md#deleteCustomField) | **DELETE** /custom-fields/{customField} | Delete custom field |
| [**getCustomField()**](MarketingApi.md#getCustomField) | **GET** /custom-fields/{customField} | Get custom field |
| [**listCustomFields()**](MarketingApi.md#listCustomFields) | **GET** /custom-fields | List custom fields |
| [**updateCustomField()**](MarketingApi.md#updateCustomField) | **PATCH** /custom-fields/{customField} | Update custom field |


## `createCustomField()`

```php
createCustomField($create_custom_field_request): \OpenAPI\Client\Model\CustomFieldResponse
```

Create custom field

Create a typed custom field definition. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MarketingApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_custom_field_request = new \OpenAPI\Client\Model\CreateCustomFieldRequest(); // \OpenAPI\Client\Model\CreateCustomFieldRequest

try {
    $result = $apiInstance->createCustomField($create_custom_field_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MarketingApi->createCustomField: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_custom_field_request** | [**\OpenAPI\Client\Model\CreateCustomFieldRequest**](../Model/CreateCustomFieldRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\CustomFieldResponse**](../Model/CustomFieldResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteCustomField()`

```php
deleteCustomField($custom_field): \OpenAPI\Client\Model\DeleteResponse
```

Delete custom field

Delete a custom field definition. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MarketingApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$custom_field = 'custom_field_example'; // string | Custom field UUID.

try {
    $result = $apiInstance->deleteCustomField($custom_field);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MarketingApi->deleteCustomField: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **custom_field** | **string**| Custom field UUID. | |

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

## `getCustomField()`

```php
getCustomField($custom_field): \OpenAPI\Client\Model\CustomFieldResponse
```

Get custom field

Retrieve a custom field definition. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MarketingApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$custom_field = 'custom_field_example'; // string | Custom field UUID.

try {
    $result = $apiInstance->getCustomField($custom_field);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MarketingApi->getCustomField: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **custom_field** | **string**| Custom field UUID. | |

### Return type

[**\OpenAPI\Client\Model\CustomFieldResponse**](../Model/CustomFieldResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listCustomFields()`

```php
listCustomFields($search, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\CustomFieldCollection
```

List custom fields

List custom field definitions. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MarketingApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = company; // string | Search names and slugs.
$sort = name; // string | Sort field.
$direction = asc; // string | Sort direction.
$page = 1; // int | Page number.
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listCustomFields($search, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MarketingApi->listCustomFields: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search names and slugs. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;name&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;asc&#39;] |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\CustomFieldCollection**](../Model/CustomFieldCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateCustomField()`

```php
updateCustomField($custom_field, $update_custom_field_request): \OpenAPI\Client\Model\CustomFieldResponse
```

Update custom field

Update a custom field definition. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\MarketingApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$custom_field = 'custom_field_example'; // string | Custom field UUID.
$update_custom_field_request = new \OpenAPI\Client\Model\UpdateCustomFieldRequest(); // \OpenAPI\Client\Model\UpdateCustomFieldRequest

try {
    $result = $apiInstance->updateCustomField($custom_field, $update_custom_field_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MarketingApi->updateCustomField: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **custom_field** | **string**| Custom field UUID. | |
| **update_custom_field_request** | [**\OpenAPI\Client\Model\UpdateCustomFieldRequest**](../Model/UpdateCustomFieldRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\CustomFieldResponse**](../Model/CustomFieldResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
