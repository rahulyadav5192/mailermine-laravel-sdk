# OpenAPI\Client\ContactsApi

Create, filter, update, delete, and restore marketing contacts.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**bulkDeleteContacts()**](ContactsApi.md#bulkDeleteContacts) | **POST** /contacts/bulk-delete | Bulk delete contacts |
| [**bulkRestoreContacts()**](ContactsApi.md#bulkRestoreContacts) | **POST** /contacts/restore | Bulk restore contacts |
| [**bulkUpdateContacts()**](ContactsApi.md#bulkUpdateContacts) | **POST** /contacts/bulk-update | Bulk update contacts |
| [**createContact()**](ContactsApi.md#createContact) | **POST** /contacts | Create contact |
| [**deleteContact()**](ContactsApi.md#deleteContact) | **DELETE** /contacts/{contact} | Delete contact |
| [**getContact()**](ContactsApi.md#getContact) | **GET** /contacts/{contact} | Get contact |
| [**listContacts()**](ContactsApi.md#listContacts) | **GET** /contacts | List contacts |
| [**restoreContact()**](ContactsApi.md#restoreContact) | **POST** /contacts/{contact}/restore | Restore contact |
| [**updateContact()**](ContactsApi.md#updateContact) | **PATCH** /contacts/{contact} | Update contact |


## `bulkDeleteContacts()`

```php
bulkDeleteContacts($bulk_contact_ids_request): \OpenAPI\Client\Model\BulkDeleteContacts200Response
```

Bulk delete contacts

Soft-delete contacts by UUID. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$bulk_contact_ids_request = new \OpenAPI\Client\Model\BulkContactIdsRequest(); // \OpenAPI\Client\Model\BulkContactIdsRequest

try {
    $result = $apiInstance->bulkDeleteContacts($bulk_contact_ids_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->bulkDeleteContacts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **bulk_contact_ids_request** | [**\OpenAPI\Client\Model\BulkContactIdsRequest**](../Model/BulkContactIdsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\BulkDeleteContacts200Response**](../Model/BulkDeleteContacts200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `bulkRestoreContacts()`

```php
bulkRestoreContacts($bulk_contact_ids_request): \OpenAPI\Client\Model\BulkRestoreContacts200Response
```

Bulk restore contacts

Restore soft-deleted contacts by UUID. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$bulk_contact_ids_request = new \OpenAPI\Client\Model\BulkContactIdsRequest(); // \OpenAPI\Client\Model\BulkContactIdsRequest

try {
    $result = $apiInstance->bulkRestoreContacts($bulk_contact_ids_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->bulkRestoreContacts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **bulk_contact_ids_request** | [**\OpenAPI\Client\Model\BulkContactIdsRequest**](../Model/BulkContactIdsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\BulkRestoreContacts200Response**](../Model/BulkRestoreContacts200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `bulkUpdateContacts()`

```php
bulkUpdateContacts($bulk_update_contacts_request): \OpenAPI\Client\Model\BulkUpdateContacts200Response
```

Bulk update contacts

Update the status of multiple contacts. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$bulk_update_contacts_request = new \OpenAPI\Client\Model\BulkUpdateContactsRequest(); // \OpenAPI\Client\Model\BulkUpdateContactsRequest

try {
    $result = $apiInstance->bulkUpdateContacts($bulk_update_contacts_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->bulkUpdateContacts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **bulk_update_contacts_request** | [**\OpenAPI\Client\Model\BulkUpdateContactsRequest**](../Model/BulkUpdateContactsRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\BulkUpdateContacts200Response**](../Model/BulkUpdateContacts200Response.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createContact()`

```php
createContact($create_contact_request): \OpenAPI\Client\Model\ContactResponse
```

Create contact

Create a contact with optional lists, tags, metadata, and custom fields. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_contact_request = new \OpenAPI\Client\Model\CreateContactRequest(); // \OpenAPI\Client\Model\CreateContactRequest

try {
    $result = $apiInstance->createContact($create_contact_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_contact_request** | [**\OpenAPI\Client\Model\CreateContactRequest**](../Model/CreateContactRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteContact()`

```php
deleteContact($contact): \OpenAPI\Client\Model\DeleteResponse
```

Delete contact

Soft-delete a contact. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact = 'contact_example'; // string | Contact UUID.

try {
    $result = $apiInstance->deleteContact($contact);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->deleteContact: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact** | **string**| Contact UUID. | |

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

## `getContact()`

```php
getContact($contact): \OpenAPI\Client\Model\ContactResponse
```

Get contact

Retrieve a contact and its loaded relationships. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact = 'contact_example'; // string | Contact UUID.

try {
    $result = $apiInstance->getContact($contact);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->getContact: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact** | **string**| Contact UUID. | |

### Return type

[**\OpenAPI\Client\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listContacts()`

```php
listContacts($search, $q, $status, $subscribed, $list, $tag, $tag_name, $source, $created_from, $created_to, $updated_from, $updated_to, $segment, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\ContactCollection
```

List contacts

Return a paginated, filterable contact collection. Required scope: `contacts.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = ada@example.com; // string | Search contact email or name.
$q = Ada; // string | Alias for `search`.
$status = active; // string | Filter by contact status.
$subscribed = true; // bool | Filter by subscription state.
$list = 'list_example'; // string | Filter by list UUID.
$tag = customer; // string | Filter by numeric tag ID or tag name.
$tag_name = customer; // string | Filter by exact tag name.
$source = api; // string | Filter by acquisition source.
$created_from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Created-at lower bound.
$created_to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Created-at upper bound.
$updated_from = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Updated-at lower bound.
$updated_to = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Updated-at upper bound.
$segment = 'segment_example'; // string | Filter by segment UUID.
$sort = created_at; // string | Sort field.
$direction = desc; // string | Sort direction.
$page = 1; // int | Page number.
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listContacts($search, $q, $status, $subscribed, $list, $tag, $tag_name, $source, $created_from, $created_to, $updated_from, $updated_to, $segment, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->listContacts: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search contact email or name. | [optional] |
| **q** | **string**| Alias for &#x60;search&#x60;. | [optional] |
| **status** | **string**| Filter by contact status. | [optional] |
| **subscribed** | **bool**| Filter by subscription state. | [optional] |
| **list** | **string**| Filter by list UUID. | [optional] |
| **tag** | **string**| Filter by numeric tag ID or tag name. | [optional] |
| **tag_name** | **string**| Filter by exact tag name. | [optional] |
| **source** | **string**| Filter by acquisition source. | [optional] |
| **created_from** | **\DateTime**| Created-at lower bound. | [optional] |
| **created_to** | **\DateTime**| Created-at upper bound. | [optional] |
| **updated_from** | **\DateTime**| Updated-at lower bound. | [optional] |
| **updated_to** | **\DateTime**| Updated-at upper bound. | [optional] |
| **segment** | **string**| Filter by segment UUID. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number. | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\ContactCollection**](../Model/ContactCollection.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `restoreContact()`

```php
restoreContact($contact): \OpenAPI\Client\Model\ContactResponse
```

Restore contact

Restore one soft-deleted contact. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact = 'contact_example'; // string | Contact UUID.

try {
    $result = $apiInstance->restoreContact($contact);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->restoreContact: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact** | **string**| Contact UUID. | |

### Return type

[**\OpenAPI\Client\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateContact()`

```php
updateContact($contact, $update_contact_request): \OpenAPI\Client\Model\ContactResponse
```

Update contact

Update contact fields and optional relationships. Required scope: `contacts.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ContactsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$contact = 'contact_example'; // string | Contact UUID.
$update_contact_request = new \OpenAPI\Client\Model\UpdateContactRequest(); // \OpenAPI\Client\Model\UpdateContactRequest

try {
    $result = $apiInstance->updateContact($contact, $update_contact_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContactsApi->updateContact: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **contact** | **string**| Contact UUID. | |
| **update_contact_request** | [**\OpenAPI\Client\Model\UpdateContactRequest**](../Model/UpdateContactRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
