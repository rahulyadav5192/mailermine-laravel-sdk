# OpenAPI\Client\AudiencesApi

Read the unified list-and-segment audience catalog.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addAudienceMembers()**](AudiencesApi.md#addAudienceMembers) | **POST** /audiences/{source}/{audience}/contacts | Add audience members |
| [**getAudience()**](AudiencesApi.md#getAudience) | **GET** /audiences/{source}/{audience} | Get audience |
| [**listAudiences()**](AudiencesApi.md#listAudiences) | **GET** /audiences | List audiences |
| [**removeAudienceMembers()**](AudiencesApi.md#removeAudienceMembers) | **DELETE** /audiences/{source}/{audience}/contacts | Remove audience members |


## `addAudienceMembers()`

```php
addAudienceMembers($source, $audience, $list_contacts_membership_request): \OpenAPI\Client\Model\AddAudienceMembers200Response
```

Add audience members

Add contacts to a list-backed audience. Segment membership is dynamic and cannot be changed directly. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AudiencesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$source = list; // string | Audience source; must be `list` for membership changes.
$audience = 'audience_example'; // string | Audience UUID.
$list_contacts_membership_request = new \OpenAPI\Client\Model\ListContactsMembershipRequest(); // \OpenAPI\Client\Model\ListContactsMembershipRequest

try {
    $result = $apiInstance->addAudienceMembers($source, $audience, $list_contacts_membership_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AudiencesApi->addAudienceMembers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **source** | **string**| Audience source; must be &#x60;list&#x60; for membership changes. | |
| **audience** | **string**| Audience UUID. | |
| **list_contacts_membership_request** | [**\OpenAPI\Client\Model\ListContactsMembershipRequest**](../Model/ListContactsMembershipRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\AddAudienceMembers200Response**](../Model/AddAudienceMembers200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getAudience()`

```php
getAudience($source, $audience): \OpenAPI\Client\Model\AudienceResponse
```

Get audience

Retrieve a list-backed or segment-backed audience. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AudiencesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$source = list; // string | Audience source type.
$audience = 'audience_example'; // string | List or segment UUID.

try {
    $result = $apiInstance->getAudience($source, $audience);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AudiencesApi->getAudience: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **source** | **string**| Audience source type. | |
| **audience** | **string**| List or segment UUID. | |

### Return type

[**\OpenAPI\Client\Model\AudienceResponse**](../Model/AudienceResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listAudiences()`

```php
listAudiences($page, $per_page): \OpenAPI\Client\Model\AudienceCollection
```

List audiences

List static lists and dynamic segments through one paginated catalog. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AudiencesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 1; // int | Page number.
$per_page = 25; // int | Items per page (maximum 100).

try {
    $result = $apiInstance->listAudiences($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AudiencesApi->listAudiences: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page (maximum 100). | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\AudienceCollection**](../Model/AudienceCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `removeAudienceMembers()`

```php
removeAudienceMembers($source, $audience, $ids): \OpenAPI\Client\Model\RemoveAudienceMembers200Response
```

Remove audience members

Remove contacts from a list-backed audience. Segment membership is dynamic and cannot be changed directly. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\AudiencesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$source = list; // string | Audience source; must be `list` for membership changes.
$audience = 'audience_example'; // string | Audience UUID.
$ids = array('ids_example'); // string[]

try {
    $result = $apiInstance->removeAudienceMembers($source, $audience, $ids);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AudiencesApi->removeAudienceMembers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **source** | **string**| Audience source; must be &#x60;list&#x60; for membership changes. | |
| **audience** | **string**| Audience UUID. | |
| **ids** | [**string[]**](../Model/string.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\RemoveAudienceMembers200Response**](../Model/RemoveAudienceMembers200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
