# OpenAPI\Client\ListsApi

Manage static contact lists and list memberships.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addContactsToList()**](ListsApi.md#addContactsToList) | **POST** /lists/{list}/contacts | Add contacts to list |
| [**bulkAddContactsToList()**](ListsApi.md#bulkAddContactsToList) | **POST** /lists/{list}/contacts/bulk-add | Add contacts to list |
| [**bulkRemoveContactsFromList()**](ListsApi.md#bulkRemoveContactsFromList) | **POST** /lists/{list}/contacts/bulk-remove | Remove contacts from list |
| [**createList()**](ListsApi.md#createList) | **POST** /lists | Create contact list |
| [**deleteList()**](ListsApi.md#deleteList) | **DELETE** /lists/{list} | Delete contact list |
| [**getList()**](ListsApi.md#getList) | **GET** /lists/{list} | Get contact list |
| [**listLists()**](ListsApi.md#listLists) | **GET** /lists | List contact lists |
| [**removeContactsFromList()**](ListsApi.md#removeContactsFromList) | **DELETE** /lists/{list}/contacts | Remove contacts from list |
| [**removeContactsFromListLegacy()**](ListsApi.md#removeContactsFromListLegacy) | **POST** /lists/{list}/contacts/remove | Remove contacts from list |
| [**updateList()**](ListsApi.md#updateList) | **PATCH** /lists/{list} | Update contact list |


## `addContactsToList()`

```php
addContactsToList($list, $list_contacts_membership_request): \OpenAPI\Client\Model\AddContactsToList200Response
```

Add contacts to list

Add contacts to a static list. Compatibility bulk routes expose the same behavior with route-specific operation IDs. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.
$list_contacts_membership_request = new \OpenAPI\Client\Model\ListContactsMembershipRequest(); // \OpenAPI\Client\Model\ListContactsMembershipRequest

try {
    $result = $apiInstance->addContactsToList($list, $list_contacts_membership_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->addContactsToList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |
| **list_contacts_membership_request** | [**\OpenAPI\Client\Model\ListContactsMembershipRequest**](../Model/ListContactsMembershipRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\AddContactsToList200Response**](../Model/AddContactsToList200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `bulkAddContactsToList()`

```php
bulkAddContactsToList($list, $list_contacts_membership_request): \OpenAPI\Client\Model\AddContactsToList200Response
```

Add contacts to list

Add contacts to a static list. Compatibility bulk routes expose the same behavior with route-specific operation IDs. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.
$list_contacts_membership_request = new \OpenAPI\Client\Model\ListContactsMembershipRequest(); // \OpenAPI\Client\Model\ListContactsMembershipRequest

try {
    $result = $apiInstance->bulkAddContactsToList($list, $list_contacts_membership_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->bulkAddContactsToList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |
| **list_contacts_membership_request** | [**\OpenAPI\Client\Model\ListContactsMembershipRequest**](../Model/ListContactsMembershipRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\AddContactsToList200Response**](../Model/AddContactsToList200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `bulkRemoveContactsFromList()`

```php
bulkRemoveContactsFromList($list, $list_contacts_membership_request): \OpenAPI\Client\Model\RemoveContactsFromList200Response
```

Remove contacts from list

Remove contacts from a static list. Compatibility POST routes expose the same behavior with route-specific operation IDs. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.
$list_contacts_membership_request = new \OpenAPI\Client\Model\ListContactsMembershipRequest(); // \OpenAPI\Client\Model\ListContactsMembershipRequest

try {
    $result = $apiInstance->bulkRemoveContactsFromList($list, $list_contacts_membership_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->bulkRemoveContactsFromList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |
| **list_contacts_membership_request** | [**\OpenAPI\Client\Model\ListContactsMembershipRequest**](../Model/ListContactsMembershipRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\RemoveContactsFromList200Response**](../Model/RemoveContactsFromList200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createList()`

```php
createList($create_list_request): \OpenAPI\Client\Model\ListResponse
```

Create contact list

Create a static contact list. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_list_request = new \OpenAPI\Client\Model\CreateListRequest(); // \OpenAPI\Client\Model\CreateListRequest

try {
    $result = $apiInstance->createList($create_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->createList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_list_request** | [**\OpenAPI\Client\Model\CreateListRequest**](../Model/CreateListRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\ListResponse**](../Model/ListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteList()`

```php
deleteList($list): \OpenAPI\Client\Model\DeleteResponse
```

Delete contact list

Delete a static contact list. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.

try {
    $result = $apiInstance->deleteList($list);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->deleteList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |

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

## `getList()`

```php
getList($list): \OpenAPI\Client\Model\ListResponse
```

Get contact list

Retrieve a contact list and its subscriber count. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.

try {
    $result = $apiInstance->getList($list);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->getList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |

### Return type

[**\OpenAPI\Client\Model\ListResponse**](../Model/ListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listLists()`

```php
listLists($search, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\ListCollection
```

List contact lists

List static contact lists with subscriber counts. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = Newsletter; // string | Search list names.
$sort = created_at; // string | Sort field.
$direction = desc; // string | Sort direction.
$page = 1; // int | Page number.
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listLists($search, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->listLists: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search list names. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\ListCollection**](../Model/ListCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `removeContactsFromList()`

```php
removeContactsFromList($list, $ids): \OpenAPI\Client\Model\RemoveContactsFromList200Response
```

Remove contacts from list

Remove contacts from a static list. Compatibility POST routes expose the same behavior with route-specific operation IDs. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.
$ids = array('ids_example'); // string[]

try {
    $result = $apiInstance->removeContactsFromList($list, $ids);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->removeContactsFromList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |
| **ids** | [**string[]**](../Model/string.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\RemoveContactsFromList200Response**](../Model/RemoveContactsFromList200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `removeContactsFromListLegacy()`

```php
removeContactsFromListLegacy($list, $list_contacts_membership_request): \OpenAPI\Client\Model\RemoveContactsFromList200Response
```

Remove contacts from list

Remove contacts from a static list. Compatibility POST routes expose the same behavior with route-specific operation IDs. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.
$list_contacts_membership_request = new \OpenAPI\Client\Model\ListContactsMembershipRequest(); // \OpenAPI\Client\Model\ListContactsMembershipRequest

try {
    $result = $apiInstance->removeContactsFromListLegacy($list, $list_contacts_membership_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->removeContactsFromListLegacy: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |
| **list_contacts_membership_request** | [**\OpenAPI\Client\Model\ListContactsMembershipRequest**](../Model/ListContactsMembershipRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\RemoveContactsFromList200Response**](../Model/RemoveContactsFromList200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateList()`

```php
updateList($list, $update_list_request): \OpenAPI\Client\Model\ListResponse
```

Update contact list

Update a static contact list. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ListsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$list = 'list_example'; // string | List UUID.
$update_list_request = new \OpenAPI\Client\Model\UpdateListRequest(); // \OpenAPI\Client\Model\UpdateListRequest

try {
    $result = $apiInstance->updateList($list, $update_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ListsApi->updateList: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list** | **string**| List UUID. | |
| **update_list_request** | [**\OpenAPI\Client\Model\UpdateListRequest**](../Model/UpdateListRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\ListResponse**](../Model/ListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
