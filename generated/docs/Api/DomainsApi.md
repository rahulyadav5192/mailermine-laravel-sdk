# OpenAPI\Client\DomainsApi

Manage sending domains, DNS records, and verification.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createDomain()**](DomainsApi.md#createDomain) | **POST** /domains | Create domain |
| [**deleteDomain()**](DomainsApi.md#deleteDomain) | **DELETE** /domains/{domain} | Delete domain |
| [**getDomain()**](DomainsApi.md#getDomain) | **GET** /domains/{domain} | Get domain |
| [**listDomains()**](DomainsApi.md#listDomains) | **GET** /domains | List domains |
| [**verifyDomain()**](DomainsApi.md#verifyDomain) | **POST** /domains/{domain}/verify | Verify domain |


## `createDomain()`

```php
createDomain($create_domain_request): \OpenAPI\Client\Model\DomainResponse
```

Create domain

Create a sending domain and return required DNS records. Required scope: `domains.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DomainsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_domain_request = new \OpenAPI\Client\Model\CreateDomainRequest(); // \OpenAPI\Client\Model\CreateDomainRequest

try {
    $result = $apiInstance->createDomain($create_domain_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DomainsApi->createDomain: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_domain_request** | [**\OpenAPI\Client\Model\CreateDomainRequest**](../Model/CreateDomainRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\DomainResponse**](../Model/DomainResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteDomain()`

```php
deleteDomain($domain): \OpenAPI\Client\Model\DeleteResponse
```

Delete domain

Delete the provider identity and soft-delete the domain. Blocked while messages are queued or sending. Required scope: `domains.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DomainsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$domain = 'domain_example'; // string | Domain UUID.

try {
    $result = $apiInstance->deleteDomain($domain);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DomainsApi->deleteDomain: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **domain** | **string**| Domain UUID. | |

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

## `getDomain()`

```php
getDomain($domain): \OpenAPI\Client\Model\DomainResponse
```

Get domain

Retrieve domain details, DNS records, statuses, and DMARC recommendation. Required scope: `domains.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DomainsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$domain = 'domain_example'; // string | Domain UUID.

try {
    $result = $apiInstance->getDomain($domain);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DomainsApi->getDomain: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **domain** | **string**| Domain UUID. | |

### Return type

[**\OpenAPI\Client\Model\DomainResponse**](../Model/DomainResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listDomains()`

```php
listDomains($search, $status, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\DomainListResponse
```

List domains

List sending domains for the authenticated project. Required scope: `domains.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DomainsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = example.com; // string | Filter by domain name.
$status = verified; // string | Filter by verification status.
$sort = 'created_at'; // string | Sort field.
$direction = 'desc'; // string | Sort direction.
$page = 1; // int | Page number (1-based).
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listDomains($search, $status, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DomainsApi->listDomains: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Filter by domain name. | [optional] |
| **status** | **string**| Filter by verification status. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number (1-based). | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\DomainListResponse**](../Model/DomainListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `verifyDomain()`

```php
verifyDomain($domain): \OpenAPI\Client\Model\DomainResponse
```

Verify domain

Check DNS and provider verification state. DNS propagation may remain pending. Required scope: `domains.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\DomainsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$domain = 'domain_example'; // string | Domain UUID.

try {
    $result = $apiInstance->verifyDomain($domain);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DomainsApi->verifyDomain: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **domain** | **string**| Domain UUID. | |

### Return type

[**\OpenAPI\Client\Model\DomainResponse**](../Model/DomainResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
