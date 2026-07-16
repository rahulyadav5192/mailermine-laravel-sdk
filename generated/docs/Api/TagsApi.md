# OpenAPI\Client\TagsApi

Organize contacts with reusable project tags.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**bulkAssignTags()**](TagsApi.md#bulkAssignTags) | **POST** /tags/bulk-assign | Bulk assign tags |
| [**bulkRemoveTags()**](TagsApi.md#bulkRemoveTags) | **POST** /tags/bulk-remove | Bulk remove tags |
| [**createTag()**](TagsApi.md#createTag) | **POST** /tags | Create tag |
| [**deleteTag()**](TagsApi.md#deleteTag) | **DELETE** /tags/{tag} | Delete tag |
| [**getTag()**](TagsApi.md#getTag) | **GET** /tags/{tag} | Get tag |
| [**listTags()**](TagsApi.md#listTags) | **GET** /tags | List tags |
| [**updateTag()**](TagsApi.md#updateTag) | **PATCH** /tags/{tag} | Update tag |


## `bulkAssignTags()`

```php
bulkAssignTags($bulk_tag_contacts_request): \OpenAPI\Client\Model\BulkAssignTags200Response
```

Bulk assign tags

Assign one or more tags to one or more contacts. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$bulk_tag_contacts_request = new \OpenAPI\Client\Model\BulkTagContactsRequest(); // \OpenAPI\Client\Model\BulkTagContactsRequest

try {
    $result = $apiInstance->bulkAssignTags($bulk_tag_contacts_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->bulkAssignTags: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **bulk_tag_contacts_request** | [**\OpenAPI\Client\Model\BulkTagContactsRequest**](../Model/BulkTagContactsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\BulkAssignTags200Response**](../Model/BulkAssignTags200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `bulkRemoveTags()`

```php
bulkRemoveTags($bulk_tag_contacts_request): \OpenAPI\Client\Model\BulkRemoveTags200Response
```

Bulk remove tags

Remove one or more tags from one or more contacts. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$bulk_tag_contacts_request = new \OpenAPI\Client\Model\BulkTagContactsRequest(); // \OpenAPI\Client\Model\BulkTagContactsRequest

try {
    $result = $apiInstance->bulkRemoveTags($bulk_tag_contacts_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->bulkRemoveTags: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **bulk_tag_contacts_request** | [**\OpenAPI\Client\Model\BulkTagContactsRequest**](../Model/BulkTagContactsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\BulkRemoveTags200Response**](../Model/BulkRemoveTags200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createTag()`

```php
createTag($create_tag_request): \OpenAPI\Client\Model\TagResponse
```

Create tag

Create a reusable contact tag. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_tag_request = new \OpenAPI\Client\Model\CreateTagRequest(); // \OpenAPI\Client\Model\CreateTagRequest

try {
    $result = $apiInstance->createTag($create_tag_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->createTag: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_tag_request** | [**\OpenAPI\Client\Model\CreateTagRequest**](../Model/CreateTagRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\TagResponse**](../Model/TagResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteTag()`

```php
deleteTag($tag): \OpenAPI\Client\Model\DeleteResponse
```

Delete tag

Delete a project tag. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$tag = 'tag_example'; // string | Tag UUID.

try {
    $result = $apiInstance->deleteTag($tag);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->deleteTag: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tag** | **string**| Tag UUID. | |

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

## `getTag()`

```php
getTag($tag): \OpenAPI\Client\Model\TagResponse
```

Get tag

Retrieve a tag with its usage count. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$tag = 'tag_example'; // string | Tag UUID.

try {
    $result = $apiInstance->getTag($tag);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->getTag: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tag** | **string**| Tag UUID. | |

### Return type

[**\OpenAPI\Client\Model\TagResponse**](../Model/TagResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listTags()`

```php
listTags($search, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\TagCollection
```

List tags

List project tags with usage counts. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = customer; // string | Search tag names.
$sort = name; // string | Sort field.
$direction = asc; // string | Sort direction.
$page = 1; // int | Page number.
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listTags($search, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->listTags: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search tag names. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;name&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;asc&#39;] |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\TagCollection**](../Model/TagCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateTag()`

```php
updateTag($tag, $update_tag_request): \OpenAPI\Client\Model\TagResponse
```

Update tag

Update a tag name or color. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$tag = 'tag_example'; // string | Tag UUID.
$update_tag_request = new \OpenAPI\Client\Model\UpdateTagRequest(); // \OpenAPI\Client\Model\UpdateTagRequest

try {
    $result = $apiInstance->updateTag($tag, $update_tag_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->updateTag: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tag** | **string**| Tag UUID. | |
| **update_tag_request** | [**\OpenAPI\Client\Model\UpdateTagRequest**](../Model/UpdateTagRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\TagResponse**](../Model/TagResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
