# OpenAPI\Client\TemplatesApi

Create, preview, duplicate, and test reusable email templates.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createTemplate()**](TemplatesApi.md#createTemplate) | **POST** /templates | Create template |
| [**deleteTemplate()**](TemplatesApi.md#deleteTemplate) | **DELETE** /templates/{template} | Delete template |
| [**duplicateTemplate()**](TemplatesApi.md#duplicateTemplate) | **POST** /templates/{template}/duplicate | Duplicate template |
| [**getTemplate()**](TemplatesApi.md#getTemplate) | **GET** /templates/{template} | Get template |
| [**listTemplates()**](TemplatesApi.md#listTemplates) | **GET** /templates | List templates |
| [**previewPublishedTemplate()**](TemplatesApi.md#previewPublishedTemplate) | **POST** /templates/preview | Preview published template |
| [**previewTemplate()**](TemplatesApi.md#previewTemplate) | **POST** /templates/{template}/preview | Preview template |
| [**testTemplate()**](TemplatesApi.md#testTemplate) | **POST** /templates/{template}/test | Test template |
| [**updateTemplate()**](TemplatesApi.md#updateTemplate) | **PATCH** /templates/{template} | Update template |


## `createTemplate()`

```php
createTemplate($create_template_request): \OpenAPI\Client\Model\TemplateResponse
```

Create template

Create a reusable template with content, variables, and branding. Required scope: `templates.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_template_request = new \OpenAPI\Client\Model\CreateTemplateRequest(); // \OpenAPI\Client\Model\CreateTemplateRequest

try {
    $result = $apiInstance->createTemplate($create_template_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->createTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_template_request** | [**\OpenAPI\Client\Model\CreateTemplateRequest**](../Model/CreateTemplateRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\TemplateResponse**](../Model/TemplateResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteTemplate()`

```php
deleteTemplate($template): \OpenAPI\Client\Model\DeleteResponse
```

Delete template

Soft-delete a template. Blocked while scheduled or active campaigns reference it. Required scope: `templates.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$template = 'template_example'; // string | Template UUID.

try {
    $result = $apiInstance->deleteTemplate($template);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->deleteTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **template** | **string**| Template UUID. | |

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

## `duplicateTemplate()`

```php
duplicateTemplate($template, $duplicate_template_request): \OpenAPI\Client\Model\TemplateResponse
```

Duplicate template

Copy content, variables, metadata, and branding into a new draft. Required scope: `templates.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$template = 'template_example'; // string | Source template UUID.
$duplicate_template_request = new \OpenAPI\Client\Model\DuplicateTemplateRequest(); // \OpenAPI\Client\Model\DuplicateTemplateRequest

try {
    $result = $apiInstance->duplicateTemplate($template, $duplicate_template_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->duplicateTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **template** | **string**| Source template UUID. | |
| **duplicate_template_request** | [**\OpenAPI\Client\Model\DuplicateTemplateRequest**](../Model/DuplicateTemplateRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\TemplateResponse**](../Model/TemplateResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getTemplate()`

```php
getTemplate($template): \OpenAPI\Client\Model\TemplateResponse
```

Get template

Retrieve full template content, variables, branding, project, and usage. Required scope: `templates.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$template = 'template_example'; // string | Template UUID.

try {
    $result = $apiInstance->getTemplate($template);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->getTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **template** | **string**| Template UUID. | |

### Return type

[**\OpenAPI\Client\Model\TemplateResponse**](../Model/TemplateResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listTemplates()`

```php
listTemplates($search, $status, $editor_type, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\TemplateListResponse
```

List templates

List templates for the authenticated project. Full HTML is omitted from list items. Required scope: `templates.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = 'search_example'; // string | Filter by name, slug, or subject.
$status = published; // string | Filter by publication status.
$editor_type = html; // string | Filter by editor/layout type.
$sort = 'created_at'; // string | Sort field.
$direction = 'desc'; // string | Sort direction.
$page = 1; // int | Page number (1-based).
$per_page = 25; // int | Items per page.

try {
    $result = $apiInstance->listTemplates($search, $status, $editor_type, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->listTemplates: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Filter by name, slug, or subject. | [optional] |
| **status** | **string**| Filter by publication status. | [optional] |
| **editor_type** | **string**| Filter by editor/layout type. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number (1-based). | [optional] [default to 1] |
| **per_page** | **int**| Items per page. | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\TemplateListResponse**](../Model/TemplateListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `previewPublishedTemplate()`

```php
previewPublishedTemplate($preview_template_by_id_request): \OpenAPI\Client\Model\TemplatePreviewResponse
```

Preview published template

Legacy preview operation that selects a published template by `template_id`. Required scope: `templates.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$preview_template_by_id_request = new \OpenAPI\Client\Model\PreviewTemplateByIdRequest(); // \OpenAPI\Client\Model\PreviewTemplateByIdRequest

try {
    $result = $apiInstance->previewPublishedTemplate($preview_template_by_id_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->previewPublishedTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **preview_template_by_id_request** | [**\OpenAPI\Client\Model\PreviewTemplateByIdRequest**](../Model/PreviewTemplateByIdRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\TemplatePreviewResponse**](../Model/TemplatePreviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `previewTemplate()`

```php
previewTemplate($template, $preview_template_request): \OpenAPI\Client\Model\TemplatePreviewResponse
```

Preview template

Render a template with runtime variables without saving or sending. Required scope: `templates.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$template = 'template_example'; // string | Template UUID.
$preview_template_request = new \OpenAPI\Client\Model\PreviewTemplateRequest(); // \OpenAPI\Client\Model\PreviewTemplateRequest

try {
    $result = $apiInstance->previewTemplate($template, $preview_template_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->previewTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **template** | **string**| Template UUID. | |
| **preview_template_request** | [**\OpenAPI\Client\Model\PreviewTemplateRequest**](../Model/PreviewTemplateRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\TemplatePreviewResponse**](../Model/TemplatePreviewResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `testTemplate()`

```php
testTemplate($template, $test_template_request): \OpenAPI\Client\Model\TemplateTestResponse
```

Test template

Queue a test email from the template. Required scopes: `templates.write` and `emails.send`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$template = 'template_example'; // string | Template UUID.
$test_template_request = new \OpenAPI\Client\Model\TestTemplateRequest(); // \OpenAPI\Client\Model\TestTemplateRequest

try {
    $result = $apiInstance->testTemplate($template, $test_template_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->testTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **template** | **string**| Template UUID. | |
| **test_template_request** | [**\OpenAPI\Client\Model\TestTemplateRequest**](../Model/TestTemplateRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\TemplateTestResponse**](../Model/TemplateTestResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateTemplate()`

```php
updateTemplate($template, $update_template_request): \OpenAPI\Client\Model\TemplateResponse
```

Update template

Partially update template content, variables, status, or branding. Required scope: `templates.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\TemplatesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$template = 'template_example'; // string | Template UUID.
$update_template_request = new \OpenAPI\Client\Model\UpdateTemplateRequest(); // \OpenAPI\Client\Model\UpdateTemplateRequest

try {
    $result = $apiInstance->updateTemplate($template, $update_template_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TemplatesApi->updateTemplate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **template** | **string**| Template UUID. | |
| **update_template_request** | [**\OpenAPI\Client\Model\UpdateTemplateRequest**](../Model/UpdateTemplateRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\TemplateResponse**](../Model/TemplateResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
