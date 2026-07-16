# OpenAPI\Client\ProjectsApi

Manage workspace projects and project settings.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createProject()**](ProjectsApi.md#createProject) | **POST** /projects | Create project |
| [**deleteProject()**](ProjectsApi.md#deleteProject) | **DELETE** /projects/{project} | Delete project |
| [**getProject()**](ProjectsApi.md#getProject) | **GET** /projects/{project} | Get project |
| [**listProjects()**](ProjectsApi.md#listProjects) | **GET** /projects | List projects |
| [**updateProject()**](ProjectsApi.md#updateProject) | **PATCH** /projects/{project} | Update project |


## `createProject()`

```php
createProject($create_project_request): \OpenAPI\Client\Model\ProjectResponse
```

Create project

Create a project for the authenticated workspace owner. Required scope: `projects.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_project_request = new \OpenAPI\Client\Model\CreateProjectRequest(); // \OpenAPI\Client\Model\CreateProjectRequest

try {
    $result = $apiInstance->createProject($create_project_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->createProject: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_project_request** | [**\OpenAPI\Client\Model\CreateProjectRequest**](../Model/CreateProjectRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\ProjectResponse**](../Model/ProjectResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteProject()`

```php
deleteProject($project): \OpenAPI\Client\Model\DeleteResponse
```

Delete project

Soft-delete a project. Deletion is blocked while active domains, queued messages, or active campaigns remain. Required scope: `projects.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Project UUID.

try {
    $result = $apiInstance->deleteProject($project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->deleteProject: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Project UUID. | |

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

## `getProject()`

```php
getProject($project): \OpenAPI\Client\Model\ProjectResponse
```

Get project

Retrieve a project owned by the authenticated workspace owner. Required scope: `projects.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 550e8400-e29b-41d4-a716-446655440000; // string | Project UUID.

try {
    $result = $apiInstance->getProject($project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProject: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Project UUID. | |

### Return type

[**\OpenAPI\Client\Model\ProjectResponse**](../Model/ProjectResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listProjects()`

```php
listProjects($search, $status, $sort, $direction, $page, $per_page): \OpenAPI\Client\Model\ProjectListResponse
```

List projects

List projects owned by the authenticated API key’s workspace owner. Required scope: `projects.read`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = production; // string | Filter by name, slug, or description.
$status = active; // string | Filter by lifecycle status.
$sort = created_at; // string | Sort field.
$direction = desc; // string | Sort direction.
$page = 1; // int | Page number (1-based).
$per_page = 25; // int | Items per page (default 25, maximum 100).

try {
    $result = $apiInstance->listProjects($search, $status, $sort, $direction, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->listProjects: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Filter by name, slug, or description. | [optional] |
| **status** | **string**| Filter by lifecycle status. | [optional] |
| **sort** | **string**| Sort field. | [optional] [default to &#39;created_at&#39;] |
| **direction** | **string**| Sort direction. | [optional] [default to &#39;desc&#39;] |
| **page** | **int**| Page number (1-based). | [optional] [default to 1] |
| **per_page** | **int**| Items per page (default 25, maximum 100). | [optional] [default to 25] |

### Return type

[**\OpenAPI\Client\Model\ProjectListResponse**](../Model/ProjectListResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateProject()`

```php
updateProject($project, $update_project_request): \OpenAPI\Client\Model\ProjectResponse
```

Update project

Partially update settings or archive/restore a project. Required scope: `projects.write`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | Project UUID.
$update_project_request = new \OpenAPI\Client\Model\UpdateProjectRequest(); // \OpenAPI\Client\Model\UpdateProjectRequest

try {
    $result = $apiInstance->updateProject($project, $update_project_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->updateProject: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| Project UUID. | |
| **update_project_request** | [**\OpenAPI\Client\Model\UpdateProjectRequest**](../Model/UpdateProjectRequest.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\ProjectResponse**](../Model/ProjectResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
