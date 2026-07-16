# WebhookDelivery

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public delivery UUID. |
**event_type** | **string** | Event type that triggered the delivery (for example &#x60;email.delivered&#x60;). |
**status** | [**\OpenAPI\Client\Model\WebhookDeliveryStatus**](WebhookDeliveryStatus.md) | Delivery status. |
**status_label** | **string** | Human-readable status label. |
**attempt** | **int** | Attempt number (1-based). |
**http_status** | **int** | HTTP status code returned by the endpoint, or &#x60;null&#x60; if not yet attempted. |
**response_headers** | **array<string,mixed>** | Response headers returned by the endpoint. |
**response_body** | **string** | Truncated response body returned by the endpoint. |
**request_body** | **string** | Signed JSON payload that was sent to the endpoint. |
**duration_ms** | **int** | Request duration in milliseconds. |
**next_retry_at** | **string** | Scheduled time of the next retry (ISO-8601), or &#x60;null&#x60;. |
**delivered_at** | **string** | Time the delivery succeeded (ISO-8601), or &#x60;null&#x60;. |
**created_at** | **string** | Creation timestamp (ISO-8601). |
**webhook** | [**\OpenAPI\Client\Model\WebhookDeliveryWebhook**](WebhookDeliveryWebhook.md) |  |
**message** | [**\OpenAPI\Client\Model\WebhookDeliveryMessage**](WebhookDeliveryMessage.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
