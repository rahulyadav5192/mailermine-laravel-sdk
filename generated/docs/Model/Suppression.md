# Suppression

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Public suppression UUID. |
**email** | **string** | Suppressed email address. |
**reason** | [**\OpenAPI\Client\Model\SuppressionReason**](SuppressionReason.md) | Reason the address was suppressed. |
**reason_label** | **string** | Human-readable reason label. |
**source** | **string** | Origin of the suppression (for example &#x60;bounce&#x60;, &#x60;manual&#x60;, &#x60;api&#x60;). |
**notes** | **string** | Optional operator notes. |
**metadata** | **array<string,mixed>** | Additional context captured with the suppression. |
**restored_at** | **string** | Time the suppression was restored (ISO-8601), or &#x60;null&#x60; if active. |
**created_at** | **string** | Creation timestamp (ISO-8601). |
**updated_at** | **string** | Last update timestamp (ISO-8601). |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
