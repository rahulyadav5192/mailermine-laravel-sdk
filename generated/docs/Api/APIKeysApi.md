# OpenAPI\Client\APIKeysApi



All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createApiKey()**](APIKeysApi.md#createApiKey) | **POST** /projects/{project}/api-keys | Create API key |
| [**deleteApiKey()**](APIKeysApi.md#deleteApiKey) | **DELETE** /projects/{project}/api-keys/{apiKey} | Delete API key |
| [**getApiKey()**](APIKeysApi.md#getApiKey) | **GET** /projects/{project}/api-keys/{apiKey} | Get API key |
| [**listApiKeys()**](APIKeysApi.md#listApiKeys) | **GET** /projects/{project}/api-keys | List API keys |
| [**revealApiKey()**](APIKeysApi.md#revealApiKey) | **POST** /projects/{project}/api-keys/{apiKey}/reveal | Reveal API key |
| [**rotateApiKey()**](APIKeysApi.md#rotateApiKey) | **POST** /projects/{project}/api-keys/{apiKey}/rotate | Rotate API key |
| [**updateApiKey()**](APIKeysApi.md#updateApiKey) | **PATCH** /projects/{project}/api-keys/{apiKey} | Update API key |


## `createApiKey()`

```php
createApiKey($project, $create_api_key_request): \OpenAPI\Client\Model\ApiKeyResponse
```

Create API key

Create an API key. The plaintext secret is returned once and cannot be recovered. Required scope: `api_keys.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$create_api_key_request = new \OpenAPI\Client\Model\CreateApiKeyRequest(); // \OpenAPI\Client\Model\CreateApiKeyRequest

try {
    $result = $apiInstance->createApiKey($project, $create_api_key_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->createApiKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **create_api_key_request** | [**\OpenAPI\Client\Model\CreateApiKeyRequest**](../Model/CreateApiKeyRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\ApiKeyResponse**](../Model/ApiKeyResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteApiKey()`

```php
deleteApiKey($project, $api_key): \OpenAPI\Client\Model\DeleteResponse
```

Delete API key

Soft-delete and revoke an API key. Required scope: `api_keys.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$api_key = 'api_key_example'; // string | API key UUID.

try {
    $result = $apiInstance->deleteApiKey($project, $api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->deleteApiKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **api_key** | **string**| API key UUID. | |

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

## `getApiKey()`

```php
getApiKey($project, $api_key): \OpenAPI\Client\Model\ApiKeyResponse
```

Get API key

Retrieve API key metadata without the secret. Required scope: `api_keys.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$api_key = 'api_key_example'; // string | API key UUID.

try {
    $result = $apiInstance->getApiKey($project, $api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->getApiKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **api_key** | **string**| API key UUID. | |

### Return type

[**\OpenAPI\Client\Model\ApiKeyResponse**](../Model/ApiKeyResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listApiKeys()`

```php
listApiKeys($project, $search, $status, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\ApiKeyListResponse
```

List API keys

List masked API keys for a project. Secrets are never returned. Required scope: `api_keys.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$search = 'search_example'; // string | Filter by key name or prefix.
$status = active; // string | Filter by status.
$sort = 'created_at'; // string | Sort field.
$direction = 'desc'; // string | Sort direction.
$page = 1; // int | Page number (1-based).
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listApiKeys($project, $search, $status, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->listApiKeys: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **search** | **string**| Filter by key name or prefix. | [optional] |
| **status** | **string**| Filter by status. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number (1-based). | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\ApiKeyListResponse**](../Model/ApiKeyListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `revealApiKey()`

```php
revealApiKey($project, $api_key): object
```

Reveal API key

Always fails because API key secrets are irreversibly hashed. Rotate the key instead. Required scope: `api_keys.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$api_key = 'api_key_example'; // string | API key UUID.

try {
    $result = $apiInstance->revealApiKey($project, $api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->revealApiKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **api_key** | **string**| API key UUID. | |

### Return type

**object**

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `rotateApiKey()`

```php
rotateApiKey($project, $api_key): \OpenAPI\Client\Model\ApiKeyResponse
```

Rotate API key

Revoke the old key and issue a replacement with the same name and scopes. The new secret is returned once. Required scope: `api_keys.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$api_key = 'api_key_example'; // string | API key UUID.

try {
    $result = $apiInstance->rotateApiKey($project, $api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->rotateApiKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **api_key** | **string**| API key UUID. | |

### Return type

[**\OpenAPI\Client\Model\ApiKeyResponse**](../Model/ApiKeyResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateApiKey()`

```php
updateApiKey($project, $api_key, $update_api_key_request): \OpenAPI\Client\Model\ApiKeyResponse
```

Update API key

Update name, expiry, status, or scopes. Required scope: `api_keys.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Parent project UUID.
$api_key = 'api_key_example'; // string | API key UUID.
$update_api_key_request = new \OpenAPI\Client\Model\UpdateApiKeyRequest(); // \OpenAPI\Client\Model\UpdateApiKeyRequest

try {
    $result = $apiInstance->updateApiKey($project, $api_key, $update_api_key_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->updateApiKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Parent project UUID. | |
| **api_key** | **string**| API key UUID. | |
| **update_api_key_request** | [**\OpenAPI\Client\Model\UpdateApiKeyRequest**](../Model/UpdateApiKeyRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\ApiKeyResponse**](../Model/ApiKeyResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
