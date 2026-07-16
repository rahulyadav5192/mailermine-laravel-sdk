# WebhookWithSecret

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public webhook UUID. |
**name** | **string** | Human-readable label for the endpoint. |
**url** | **string** | HTTPS URL that receives signed event deliveries. |
**is_active** | **bool** | Whether the endpoint is currently active. |
**enabled** | **bool** | Alias of &#x60;is_active&#x60; retained for backward compatibility. |
**subscribed_events** | **string[]** | Subscribed event types. Values match the webhook event catalog (for example &#x60;email.delivered&#x60;, &#x60;email.bounced&#x60;, &#x60;campaign.completed&#x60;). |
**retry_policy** | [**\OpenAPI\Client\Model\WebhookRetryPolicy**](WebhookRetryPolicy.md) |  |
**last_delivery** | [**\OpenAPI\Client\Model\WebhookLastDelivery**](WebhookLastDelivery.md) |  |
**created_at** | **string** | Creation timestamp (ISO-8601). |
**updated_at** | **string** | Last update timestamp (ISO-8601). |
**project** | [**\OpenAPI\Client\Model\WebhookProject**](WebhookProject.md) |  |
**signing_secret** | **string** | HMAC signing secret. Returned only when creating a webhook or rotating its secret — store it securely, it is never shown again. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
