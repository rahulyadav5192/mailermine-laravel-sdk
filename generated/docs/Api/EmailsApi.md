# OpenAPI\Client\EmailsApi

Send transactional email with attachments, CC/BCC, headers, tags, and metadata.

All URIs are relative to http://127.0.0.1:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**sendEmail()**](EmailsApi.md#sendEmail) | **POST** /emails | Send email |


## `sendEmail()`

```php
sendEmail($send_email_request): \OpenAPI\Client\Model\SendEmailResponse
```

Send email

Queue a transactional email for delivery. Supports attachments, CC/BCC, reply-to, headers, tags, and metadata.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (API Key) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EmailsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$send_email_request = new \OpenAPI\Client\Model\SendEmailRequest(); // \OpenAPI\Client\Model\SendEmailRequest

try {
    $result = $apiInstance->sendEmail($send_email_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmailsApi->sendEmail: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **send_email_request** | [**\OpenAPI\Client\Model\SendEmailRequest**](../Model/SendEmailRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\SendEmailResponse**](../Model/SendEmailResponse.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
